<?php

namespace App\Livewire\Formality;

use App\Domain\Program\Services\FileUploadigService;
use App\Livewire\Forms\Formality\FormalityUpdate;
use App\Models\Country;
use App\Models\File;
use App\Models\FileConfig;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Models\Address;
use App\Models\ComponentOption;
use App\Models\Formality;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

class EditFormalityForm extends Component
{
    use WithFileUploads;

    protected $formalityService;
    protected $addressService;
    protected $userService;

    // fields
    public FormalityUpdate $form;
    public int $formalityId;
    public $formality;

    public $target_provinceId;
    public $target_clientProvinceId;

    public $businessClientType;
    public $businessDocumentType;

    public $documentTypes;

    public $field_name = 'Nombre';

    public $isBusinessPerson = false;

    public $same_address;

    public $files;
    public $formality_file;

    public Collection $inputs;

    public Collection $service_file;

    private $fileSet;

    private FileUploadigService $fileUploadigService;

    public Country $selected_country;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->fileUploadigService = App::make(FileUploadigService::class);
        $this->businessClientType = ComponentOption::where('name', ClientTypeEnum::BUSINESS->value)->first();
        $this->businessDocumentType = ComponentOption::where('name', DocumentTypeEnum::CIF->value)->first();
    }


    public function mount($formality)
    {
        $this->formality = $formality;
        $this->formalityId = $formality->id;
        $this->form->setformality($this->formality);
        $this->target_provinceId = $this->form->provinceId;
        $this->target_clientProvinceId = $this->form->client_provinceId;
        $this->documentTypes = $this->userService->getDocumentTypes();

        //$this->same_address = $this->form->is_same_address;

        $this->clientTypeId = $this->form->clientTypeId;

        if ($this->clientTypeId == $this->businessClientType->id) {
            $this->isBusinessPerson = true;
            $this->field_name = 'Razon social';
        }

        $this->fileSet = $this->formalityService->getFileById($this->formalityId);

        if ($this->fileSet) {
            $this->files = $this->fileSet->files;
            $this->mountFilesInput();
            //$this->addInput($this->formality->service_id);
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

    public function mountFilesInput()
    {
        $fileConfig = FileConfig::whereNull('component_option_id')->get();

        $this->fill([
            'inputs' => collect([['' => '']]),
            'service_file' => collect([['', '']]),
        ]);

        foreach ($fileConfig as $value) {
            $this->inputs->push(['configId' => $value->id, 'serviceId' => null, 'name' => $value->name, 'file' => '']);
        }

        $this->inputs->pull(0);
        $this->service_file->pull(0);
    }

    public function addInput($serviceId)
    {

        foreach ($this->service_file as $key => $value) {
            $this->service_file->pull($key);

        }
        if ($serviceId !== $this->formality->service_id) {
            $config = FileConfig::where('component_option_id', $serviceId)->first();
            $this->service_file->push(['serviceId' => $serviceId, 'configId' => $config->id, 'name' => $config->name, 'file' => '']);

        }


    }

    protected $rules = [
        'inputs.*.file' => 'sometimes|nullable|mimes:pdf|max:5240',
        'service_file.*.file' => 'sometimes|nullable|mimes:pdf|max:5240',
    ];

    protected $messages = [
        'inputs.*.file.mimes' => 'El archivo debe ser un pdf.',
        'inputs.*.file.max' => 'El archivo debe ser menor a 5MB.',
        'service_file.*.file.mimes' => 'El archivo debe ser un pdf.',
        'service_file.*.file.max' => 'El archivo debe ser menor a 5MB.',
    ];

    public function update()
    {
        $this->formValidation();

        if ($this->isDuplicated()) {
            $this->dispatch('checks', error: "Error al intentar editar el formulario, ya existe un trámite con los mismo datos.", title: "Datos duplicados");
        } else {
            $this->executeUpdate();
        }


    }

    private function executeUpdate()
    {
        DB::beginTransaction();

        try {

            $updates = array_merge(['country_id' => $this->selected_country->id], $this->form->getclientUpdate());

            $data = Formality::firstWhere('id', $this->formalityId);
            $data->client()->update($updates);

            $address = Address::firstWhere('id', $data->address->id);
            $address->update($this->form->getaddressUpdate());

            $data->update($this->form->getFormalityUpdate());

            $data->save();

            if ($data->CorrespondenceAddress !== null) {
                $corresponceAddress = Address::firstWhere('id', $data->CorrespondenceAddress->id);
                $corresponceAddress->update($this->form->getCorresponceAddressUpdate());
            }

            $object = $this->service_file->where('serviceId', $this->form->serviceIds[0])->first();
            if ($object != null && $object['file'] != null) {

                $file = $object['file'];
                $stored_file = $data->with('files')->first()->files->first();
                if ($file) {
                    $this->fileUploadigService
                        ->addFile($file)
                        ->setConfigId($object['configId'])
                        ->force_replace($stored_file);

                }
            }

            $files_client = $this->inputs->where('serviceId', null);
            $stored_client_client = $data->client()->with('files')->first()->files;
            foreach ($files_client as $key => $value) {
                if ($value['file'] != null) {
                    $target_file = $stored_client_client->where('config_id', $value['configId'])->first();
                    if ($target_file) {
                        $this->fileUploadigService
                            ->addFile($value['file'])
                            ->setConfigId($value['configId'])
                            ->force_replace($target_file);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.formality.inprogress');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
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
        $locations = $this->addressService->getLocations((int) $this->target_provinceId);
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
        $clientLocation = $this->addressService->getLocations((int) $this->target_clientProvinceId);
        return $clientLocation;
    }

    public function formstate()
    {
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

    private function formValidation()
    {
        $country = Country::firstWhere('name', 'spain');
        $phoneRule = $country->id == $this->selected_country->id ? 'required|string|spanish_phone' : 'nullable|string|min:11|max:11';
        $this->form->validate(
            [
                'phone' => $phoneRule
            ],
            [
                'phone.min' => 'El campo debe ser un telefono valido.',
                'phone.max' => 'El campo debe ser un telefono valido.',
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
                    'secondLastName' => 'required|string',
                    'userTitleId' => 'required|integer|exists:component_option,id',
                    'documentNumber' => $documentRule
                ],
                [

                    'firstLastName.required' => 'El campo Primer Apellido es obligatorio',
                    'secondLastName.required' => 'El campo Segundo Apellido es obligatorio',
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

        $inputServiceid = intval($this->form->serviceIds[0]);
        if ($this->formality->service_id !== $inputServiceid) {
            $this->validate(
                [
                    'service_file.*.file' => 'required',
                ],
                [
                    'service_file.*.file.required' => 'El campo Archivo es obligatorio',
                ]
            );
        }
    }

    public function isDuplicated(): bool
    {
        $Formality = Formality::whereHas('client', function ($query) {
            $query->where('id', $this->formality->client->id);
        })->whereHas('service', function ($query) {
            $query->where('id', $this->form->serviceIds[0]);
        })->whereHas('address', function ($query) {
            $query->where('id', $this->formality->address->id);
        })->where('id', '!=', $this->formality->id);

        if ($Formality->exists()) {
            return true;
        } else {
            return false;
        }

    }

    public function changeSameAddress()
    {
        $this->same_address = !$this->same_address;

        if (!$this->same_address) {
            $this->form->reset(
                'client_locationId',
                'client_streetTypeId',
                'client_housingTypeId',
                'client_streetName',
                'client_streetNumber',
                'client_zipCode',
                'client_block',
                'client_blockstaircase',
                'client_floor',
                'client_door'
            );
        }

    }

    public function render()
    {
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $services = $services->where('name', '!=', 'fibra');
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        $countries = Country::all();
        return view('livewire.formality.edit-formality-form', [
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
