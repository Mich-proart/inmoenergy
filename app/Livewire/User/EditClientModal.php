<?php

namespace App\Livewire\User;

use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\Formality\Services\ServicesBasedOnEmail;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\Formality\FormalityUpdate;
use App\Models\Address;
use App\Models\ClientAddress;
use App\Models\ComponentOption;
use App\Models\Country;
use App\Models\Formality;
use DB;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditClientModal extends Component
{
    use WithFileUploads;

    public $clientFiles = [];
    protected AddressService $addressService;
    protected UserService $userService;

    protected FormalityService $formalityService;
    protected ServicesBasedOnEmail $servicesBasedOnEmail;

    public FormalityUpdate $form;

    public $formality;

    // Reassignment fields
    public $reassignmentMode = 'edit';
    public $searchClientQuery = '';
    public $selectedNewClientId = null;
    public $searchResults = [];

    public $target_provinceId;
    public $target_clientProvinceId;

    public $businessClientType;
    public $businessDocumentType;

    public $documentTypes;

    public $field_name = 'Nombre';

    public $isBusinessPerson = false;

    public $same_address;

    public Country $selected_country;

    public $clientTypeId;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->servicesBasedOnEmail = App::make(ServicesBasedOnEmail::class);
        $this->businessClientType = ComponentOption::where('name', ClientTypeEnum::BUSINESS->value)->first();
        $this->businessDocumentType = ComponentOption::where('name', DocumentTypeEnum::CIF->value)->first();
    }

    public function mount($formality)
    {
        $this->form->setformality($this->formality);
        $this->target_provinceId = $this->form->provinceId;
        $this->target_clientProvinceId = $this->form->client_provinceId;
        $this->documentTypes = $this->userService->getDocumentTypes();

        $this->clientTypeId = $this->form->clientTypeId;

        if ($this->form->clientTypeId == $this->businessClientType->id) {
            $this->isBusinessPerson = true;
            $this->field_name = 'Razon social';
        }

        $this->changeCountry($formality->client->country_id);

    }

    public function changeCountry($id)
    {
        $country = Country::firstWhere('id', $id);
        if ($country) {
            $this->selected_country = $country;
        }
    }

    public function update()
    {
        $this->formValidation();
        $this->executeUpdate();

    }


    private function executeUpdate()
    {
        DB::beginTransaction();

        try {
            $data = Formality::firstWhere('id', $this->formality->id);

            if ($this->reassignmentMode === 'edit') {
                $updates = array_merge(['country_id' => $this->selected_country->id], $this->form->getclientUpdate());
                $data->client()->update($updates);
            } elseif ($this->reassignmentMode === 'select') {
                if (!$this->selectedNewClientId) {
                    throw new \Exception('Debe seleccionar un cliente de la lista.');
                }
                
                // Detach client documents from this formality (relation only)
                $clientFileIds = $data->files()
                    ->whereHas('config', function($query) {
                        $query->where('tipo_carpeta', 'DocumentacionCliente');
                    })
                    ->pluck('files.id');
                $data->files()->detach($clientFileIds);

                $data->client_id = $this->selectedNewClientId;
            } elseif ($this->reassignmentMode === 'new') {
                $updates = array_merge(['country_id' => $this->selected_country->id], $this->form->getclientUpdate());
                $newClient = \App\Models\Client::create($updates);
                
                // Upload and save client files
                if (!empty($this->clientFiles)) {
                    $uploaderService = \Illuminate\Support\Facades\App::make(\App\Domain\Program\Services\FileUploadigService::class);
                    foreach ($this->clientFiles as $configId => $fileObj) {
                        if ($fileObj) {
                            $uploaderService
                                ->setModel($newClient)
                                ->addFile($fileObj)
                                ->setConfigId($configId)
                                ->saveFile();
                        }
                    }
                }

                // Detach client documents from this formality (relation only)
                $clientFileIds = $data->files()
                    ->whereHas('config', function($query) {
                        $query->where('tipo_carpeta', 'DocumentacionCliente');
                    })
                    ->pluck('files.id');
                $data->files()->detach($clientFileIds);

                $data->client_id = $newClient->id;
            }

            $address = Address::firstWhere('id', $data->address->id);
            $address->update($this->form->getaddressUpdate());

            $data->save();

            if ($data->CorrespondenceAddress !== null) {
                $corresponceAddress = Address::firstWhere('id', $data->CorrespondenceAddress->id);
                $corresponceAddress->update($this->form->getCorresponceAddressUpdate());
            }

            DB::commit();
            $this->dispatch('end-update');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function formstate()
    {
        $this->clientFiles = [];
        $current_client_type = null;


        if ($this->form->clientTypeId !== null) {
            $this->documentTypes = $this->userService->getDocumentTypes();
            $current_client_type = ComponentOption::where('id', $this->form->clientTypeId)->first();

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::BUSINESS->value) {

                $this->field_name = 'Razon social';
                $this->isBusinessPerson = true;

                $documentType = $this->userService->getDocumentTypes();
                $documentType = $documentType->where('name', DocumentTypeEnum::CIF->value)->first();

                $this->form->setDocumentTypeId($documentType->id);
                $this->form->reset(['firstLastName', 'secondLastName', 'userTitleId']);


            }

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::PERSON->value) {
                $this->field_name = 'Nombre';
                $this->isBusinessPerson = false;
                $documentTypes = $this->userService->getDocumentTypes();
                $this->documentTypes = $documentTypes->where('name', '!=', DocumentTypeEnum::CIF->value);
            }

        }
    }

    public function getClientDocConfigs()
    {
        $current_client_type = ComponentOption::find($this->form->clientTypeId);
        $query = \App\Models\FileConfig::where('tipo_carpeta', 'DocumentacionCliente');

        if ($current_client_type) {
            if ($current_client_type->name === ClientTypeEnum::PERSON->value) {
                $query->whereNotIn('name', ['CIF', 'escritura empresa']);
            } elseif ($current_client_type->name === ClientTypeEnum::BUSINESS->value) {
                $query->whereNotIn('name', ['DNI (Ambas caras)', 'autorización hacia InmoEnergy']);
            }
        }
        return $query->get();
    }

    public function updatedSearchClientQuery($value)
    {
        if (strlen($value) >= 3) {
            $this->searchResults = \App\Models\Client::where('name', 'like', '%' . $value . '%')
                ->orWhere('first_last_name', 'like', '%' . $value . '%')
                ->orWhere('second_last_name', 'like', '%' . $value . '%')
                ->orWhere('document_number', 'like', '%' . $value . '%')
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectExistingClient($clientId)
    {
        $this->selectedNewClientId = $clientId;
        $client = \App\Models\Client::find($clientId);
        if ($client) {
            $this->form->name = $client->name;
            $this->form->firstLastName = $client->first_last_name;
            $this->form->secondLastName = $client->second_last_name;
            $this->form->documentNumber = $client->document_number;
            $this->form->phone = $client->phone;
            $this->form->email = $client->email;
            $this->form->IBAN = $client->IBAN;
            $this->form->clientTypeId = $client->client_type_id;
            $this->form->userTitleId = $client->user_title_id;
            $this->clientTypeId = $client->client_type_id;
            
            $this->changeCountry($client->country_id);
            $this->formstate();
        }
    }

    public function updatedReassignmentMode($value)
    {
        $this->clientFiles = [];
        if ($value === 'edit') {
            $this->form->setformality($this->formality);
            $this->selectedNewClientId = null;
        } elseif ($value === 'new') {
            $this->form->name = '';
            $this->form->firstLastName = '';
            $this->form->secondLastName = '';
            $this->form->documentNumber = '';
            $this->form->phone = '';
            $this->form->email = '';
            $this->form->IBAN = '';
            $this->form->clientTypeId = null;
            $this->form->userTitleId = null;
            $this->selectedNewClientId = null;
        } else { // select
            $this->searchClientQuery = '';
            $this->searchResults = [];
            $this->selectedNewClientId = null;
            $this->form->name = '';
            $this->form->firstLastName = '';
            $this->form->secondLastName = '';
            $this->form->documentNumber = '';
            $this->form->phone = '';
            $this->form->email = '';
            $this->form->IBAN = '';
        }
    }

    public function setMode($mode)
    {
        $this->reassignmentMode = $mode;
        $this->updatedReassignmentMode($mode);
    }

    #[Computed()]
    public function provinces()
    {
        $province = $this->addressService->getProvinces();
        return $province;
    }

    #[Computed()]
    public function locations()
    {
        $locations = $this->addressService->getLocations((int)$this->target_provinceId);
        return $locations;
    }

    #[Computed()]
    public function clientProvinces()
    {
        $clientProvince = $this->addressService->getProvinces();
        return $clientProvince;
    }

    #[Computed()]
    public function clientLocations()
    {
        $clientLocation = $this->addressService->getLocations((int)$this->target_clientProvinceId);
        return $clientLocation;
    }

    private function formValidation()
    {
        if ($this->reassignmentMode === 'new') {
            $this->validate([
                'clientFiles.*' => 'nullable|file|mimes:pdf,jpg|max:5240',
            ], [
                'clientFiles.*.mimes' => 'El archivo debe ser un PDF o JPG.',
                'clientFiles.*.max' => 'El archivo debe ser menor a 5MB.',
            ]);
        }

        if ($this->reassignmentMode === 'select') {
            $this->validate([
                'selectedNewClientId' => 'required|exists:client,id'
            ], [
                'selectedNewClientId.required' => 'Debe buscar y seleccionar un cliente de la lista.'
            ]);
            return;
        }

        $this->form->validate();
        $phoneRule = 'required|string|phone:' . $this->selected_country->iso2;
        $this->form->validate(
            [
                'phone' => $phoneRule
            ],
            [
                'phone.min' => 'El campo debe ser un telefono valido.',
                'phone.max' => 'El campo debe ser un telefono valido.',
                'phone.required' => 'El campo es requerido.',
                'phone.phone' => 'El campo debe ser un telefono valido.',
            ]
        );

        $selectedClientType = ComponentOption::where('id', $this->form->clientTypeId)->first();
        $selectedDocumentType = ComponentOption::where('id', $this->form->documentTypeId)->first();
        if ($selectedClientType && $selectedClientType->name === ClientTypeEnum::PERSON->value) {

            $documentRule = '';

            if ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::PASSPORT->value) {
                $documentRule = 'required|string|min:9|max:9';
            } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::DNI->value) {
                $documentRule = DocumentRule::$DNI;
            } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::NIE->value) {
                $documentRule = DocumentRule::$NIE;
            }

            $this->form->validate(
                [
                    'firstLastName' => 'required|string',
                    'userTitleId' => 'required|integer|exists:component_option,id',
                    'documentNumber' => $documentRule
                ],
                [

                    'firstLastName.required' => 'El campo Primer Apellido es obligatorio',
                    'firstLastName.string' => 'El campo Primer Apellido debe ser una cadena de texto',
                    'userTitleId.required' => 'El campo Titulo es obligatorio',
                    'userTitleId.exists' => 'El Titulo no es valido',
                    'documentNumber.required' => 'El campo Documento es obligatorio',

                ]
            );
        }


        if ($selectedClientType && $selectedClientType->name === ClientTypeEnum::BUSINESS->value) {
            $this->form->validate(
                [
                    'documentNumber' => DocumentRule::$CIF
                ],
                [
                    'documentNumber.required' => 'El campo Cif es obligatorio',
                    'documentNumber.cif' => 'El Cif no es valido',
                ],
            );
        }

    }

    public function isDuplicatedAddress()
    {
        return ClientAddress::whereHas('client', function ($query) {
            $query->where('id', $this->formality->client_id);
        })->whereHas('address', function ($query) {
            $query->where('location_id', $this->form->locationId)
                ->where('street_type_id', $this->form->streetTypeId)
                ->where('housing_type_id', $this->form->housingTypeId)
                ->where('street_name', $this->form->streetName)
                ->where('street_number', $this->form->streetNumber)
                ->where('zip_code', $this->form->zipCode)
                ->where('block', $this->form->block)
                ->where('block_staircase', $this->form->blockstaircase)
                ->where('floor', $this->form->floor)
                ->where('door', $this->form->door);
        })->first();
    }


    public function render()
    {

        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes()->where('name', '!=', 'renovación');

        $services = $this->formalityService->getServices()->whereNotIn('id', $this->servicesBasedOnEmail->list_ids);
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        $countries = Country::all();

        return view('livewire.user.edit-client-modal', [
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
            'formalitytypes' => $formalitytypes,
            'services' => $services,
            'clientTypes' => $clientTypes,
            'userTitles' => $userTitles,
            'countries' => $countries
        ]);
    }
}
