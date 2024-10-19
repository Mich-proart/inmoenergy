<?php

namespace App\Livewire\Formality;

use App\Livewire\Forms\Formality\FormalityCreate;
use App\Models\Address;
use App\Models\Client;
use App\Models\Country;
use App\Models\Formality;
use Livewire\Component;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use DB;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;
use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Program\Services\FileUploadigService;
use App\Mail\EmailLineaTelefonica;
use App\Models\ComponentOption;
use App\Models\FileConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Domain\Address\Services\AddressService;
use App\Domain\Formality\Services\CreateFormalityService;
use Illuminate\Mail\Mailables\Attachment;

class CreateFormalityForm extends Component
{

    public FormalityCreate $form;

    use WithFileUploads;
    public $target_provinceId;
    public $target_clientProvinceId;

    public $folder;

    public $file_fields = ['dni', 'factura_agua', 'factura_gas', 'factura_luz'];


    public $businessClientType;
    public $businessDocumentType;

    public $documentTypes;

    public Collection $inputs;

    private FileUploadigService $fileUploadigService;

    private ComponentOption $fibra;

    protected $userService;
    protected $formalityService;
    protected $addressService;

    protected $createFormalityService;

    public Country $selected_country;

    public function __construct()
    {
        $this->createFormalityService = App::make(CreateFormalityService::class);
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->businessClientType = ComponentOption::where('name', ClientTypeEnum::BUSINESS->value)->first();
        $this->businessDocumentType = ComponentOption::where('name', DocumentTypeEnum::CIF->value)->first();
        $this->fileUploadigService = App::make(FileUploadigService::class);
        $this->fibra = ComponentOption::where('name', 'fibra')->first();
    }

    public function mount()
    {
        $this->documentTypes = $this->userService->getDocumentTypes();

        $fileConfig = FileConfig::whereNull('component_option_id')->get();

        $this->fill([
            'inputs' => collect([['' => '']]),
        ]);

        foreach ($fileConfig as $value) {
            $this->inputs->push(['configId' => $value->id, 'serviceId' => null, 'name' => $value->name, 'file' => '']);
        }

        $this->inputs->pull(0);

        $country = Country::firstWhere('name', 'spain');

        if ($country) {
            $this->selected_country = $country;
        }

        $clientProvince = $this->addressService->getProvinces();
        $key = $clientProvince->where('name', 'Barcelona')->first();

        if ($key) {
            $this->target_provinceId = $key->id;
        }


    }

    public function changeCountry($id)
    {
        $country = Country::firstWhere('id', $id);
        if ($country) {
            $this->selected_country = $country;
        }
    }

    public function addInput($serviceId)
    {
        // if ($serviceId !== $this->fibra->id) {
        if ($this->inputs->contains('serviceId', $serviceId)) {

            foreach ($this->inputs as $key => $value) {
                if ($value['serviceId'] == $serviceId) {
                    $this->inputs->pull($key);
                }
            }
            $this->inputs->pull('serviceId', $serviceId);
        } else {
            $config = FileConfig::where('component_option_id', $serviceId)->first();
            $this->inputs->push(['serviceId' => $serviceId, 'configId' => $config->id, 'name' => $config->name, 'file' => '']);
        }
        // }

    }

    protected $rules = [
        'inputs.*.file' => 'required|mimes:pdf|max:5240',
    ];

    protected $messages = [
        'inputs.*.file.required' => 'Selecione un archivo.',
        'inputs.*.file.mimes' => 'El archivo debe ser un pdf.',
        'inputs.*.file.max' => 'El archivo debe ser menor a 5MB.',
    ];

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

    public $field_name = 'Nombre';

    public function formstate()
    {
        $current_client_type = null;


        if ($this->form->clientTypeId !== null) {
            $this->documentTypes = $this->userService->getDocumentTypes();
            $current_client_type = ComponentOption::where('id', $this->form->clientTypeId)->first();

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::BUSINESS->value) {

                $this->field_name = 'Razon social';

                $documentType = $this->userService->getDocumentTypes();
                $documentType = $documentType->where('name', DocumentTypeEnum::CIF->value)->first();

                $this->form->setDocumentTypeId($documentType->id);
                $this->form->reset(['firstLastName', 'secondLastName', 'userTitleId']);


            }

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::PERSON->value) {
                $this->field_name = 'Nombre';
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
        $this->validate();

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

            $this->form->validate([
                'firstLastName' => 'required|string',
                'secondLastName' => 'required|string',
                'userTitleId' => 'required|integer|exists:component_option,id',
                'documentNumber' => $documentRule
            ], [
                'firstLastName.required' => 'El campo Primer Apellido es obligatorio',
                'secondLastName.required' => 'El campo Segundo Apellido es obligatorio',
                'userTitleId.required' => 'El campo Titulo es obligatorio',
                'userTitleId.exists' => 'El Titulo no es valido',
            ]);
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

    public function save()
    {

        $this->formValidation();

        if ($this->isDuplicated()) {
            $this->dispatch('checks', error: "Error al intentar crear el formulario, ya existe un trámite con los mismo datos.", title: "Datos duplicados");
        } else {
            $this->dispatch('load');
            $this->execute();
        }

    }

    private function execute()
    {
        DB::beginTransaction();
        try {
            $this->folder = $this->getFolderName();

            if (in_array($this->fibra->id, $this->form->serviceIds)) {
                $this->emailRequest();
            }


            if (count($this->form->serviceIds) > 0) {
                $newdata = array_merge(['country_id' => $this->selected_country->id], $this->form->getClientDto());
                $client = Client::create($newdata);
                $address = Address::create($this->form->getCreateAddressDto());

                $this->createFormalityService->setClientId($client->id);
                $this->createFormalityService->setUserIssuerId(Auth::user()->id);
                $this->createFormalityService->setAddresId($address->id);


                $clientAddres = new Address();

                if (!$this->form->is_same_address) {
                    $clientAddres = Address::create($this->form->getCreateClientAddressDto());
                } else {
                    $clientAddres = Address::create($this->form->getCreateAddressDto());
                }

                $this->createFormalityService->setCorrespondenceAddressId($clientAddres->id);
                //$client->update(['address_id' => $clientAddres->id]);

                $client->addresses()->attach([$clientAddres->id => ['iscorrespondence' => true], $address->id => ['iscorrespondence' => false]]);


                $file_inputs = $this->inputs->where('serviceId', null);
                foreach ($file_inputs as $file_input) {
                    $this->fileUploadigService
                        ->setModel($client)
                        ->addFile($file_input['file'])
                        ->setConfigId($file_input['configId'])
                        ->saveFile($this->folder);
                }

                foreach ($this->form->serviceIds as $serviceId) {


                    $formality = $this->createFormalityService->execute($serviceId, $this->form->formalityTypeId[0], $this->form->observation);

                    $object = $this->inputs->where('serviceId', $serviceId)->first();

                    $file = $object['file'];
                    if ($file) {
                        $this->fileUploadigService
                            ->setModel($formality)
                            ->addFile($file)
                            ->setConfigId($object['configId'])
                            ->saveFile($this->folder);

                        $this->fileUploadigService->addExistingFile($client->files);
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

    public function isDuplicated(): bool
    {
        return Address::where('location_id', $this->form->locationId)
            ->where('street_type_id', $this->form->streetTypeId)
            ->where('housing_type_id', $this->form->housingTypeId)
            ->where('street_name', $this->form->streetName)
            ->where('street_number', $this->form->streetNumber)
            ->where('zip_code', $this->form->zipCode)
            ->where('block', $this->form->block)
            ->where('block_staircase', $this->form->blockstaircase)
            ->where('floor', $this->form->floor)
            ->where('door', $this->form->door)
            ->exists();

    }

    private function getFolderName(): string
    {
        return $this->form->name . ucfirst($this->form->firstLastName) . '_' . $this->form->documentNumber . '_' . date('Y-m-d');
    }


    private function emailRequest()
    {
        $attachs = array();
        $file_inputs = $this->inputs->where('serviceId', null);
        $object = $this->inputs->where('serviceId', $this->fibra->id)->first();
        $file_inputs->push($object);

        foreach ($file_inputs as $file_input) {
            $target = $this->fileUploadigService
                ->addFile($file_input['file'])
                ->saveFile($this->folder);
            array_push($attachs, Attachment::fromPath(storage_path('app/public/' . $target)));
        }
        $newdata = array_merge(['phone_code' => $this->selected_country->phone_code], $this->form->getClientDto());
        Mail::to(['jose.gomez@inmoenergy.es', 'inmobiliarias@inmoenergy.es'])
            ->send(new EmailLineaTelefonica($newdata, $this->form->getCreateAddressDto(), $attachs));

        $this->form->serviceIds = array_diff($this->form->serviceIds, [$this->fibra->id]);
    }



    public function render()
    {
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        $countries = Country::all();
        return view('livewire.formality.create-formality-form', [
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
