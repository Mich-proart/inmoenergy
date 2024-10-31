<?php

namespace App\Livewire\Formality;

use App\Domain\Common\FormalityStatusNotDuplicated;
use App\Exceptions\CustomException;
use App\Livewire\Forms\Formality\FormalityClientCreate;
use App\Models\Address;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ComponentOption;
use App\Models\FileConfig;
use App\Models\Formality;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use DB;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;
use App\Domain\User\Services\UserService;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\Address\Services\AddressService;
use App\Mail\EmailLineaTelefonica;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Attachment;
use App\Domain\Formality\Services\CreateFormalityService;
use Illuminate\Support\Facades\Auth;
use App\Domain\Program\Services\FileUploadigService;

class CreateByClient extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $clients = [];
    public $search_full_name = '';
    public $search_document_number = '';
    public $search_client_type_id = 0;

    public $target_provinceId;
    public $target_clientProvinceId;

    public $folder;

    public Client $client;
    public Collection $inputs;

    public FormalityClientCreate $form;
    protected $createFormalityService;

    protected $userService;
    protected $formalityService;

    public Collection $addressHandler;
    protected $addressService;

    public $selected_handler;
    public $selectedAddressId = [];

    public bool $is_same_address = true;

    private ComponentOption $fibra;
    private FileUploadigService $fileUploadigService;

    protected $rules = [
        'inputs.*.file' => 'required|mimes:pdf|max:5240',
    ];

    protected $messages = [
        'inputs.*.file.required' => 'Selecione un archivo.',
        'inputs.*.file.mimes' => 'El archivo debe ser un pdf.',
        'inputs.*.file.max' => 'El archivo debe ser menor a 5MB.',
    ];


    public function __construct()
    {
        $this->createFormalityService = App::make(CreateFormalityService::class);
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->fibra = ComponentOption::where('name', 'fibra')->first();
        $this->fileUploadigService = App::make(FileUploadigService::class);
    }


    public function mount()
    {
        $this->fill([
            'inputs' => collect([['' => '']]),
            'addressHandler' => collect([
                ['handler' => 'getAddress', 'display' => 'listado de direcciones', 'isChecked' => true],
                ['handler' => 'newAddress', 'display' => 'Nueva dirección', 'isChecked' => false]
            ])
        ]);
        $this->inputs->pull(0);
        $this->selected_handler = 'getAddress';
    }

    public function switchAddressHandler()
    {
        $this->reset(['selectedAddressId', 'target_provinceId']);
        $this->form->reset([
            'selectedAddressId',
            'locationId',
            'streetTypeId',
            'housingTypeId',
            'streetName',
            'streetNumber',
            'zipCode',
            'block',
            'blockstaircase',
            'floor',
            'door',
        ]);
    }

    public function changeCorrespondece()
    {
        $this->reset(['target_clientProvinceId']);
        $this->form->reset([
            'client_locationId',
            'client_streetTypeId',
            'client_housingTypeId',
            'client_streetName',
            'client_streetNumber',
            'client_zipCode',
            'client_block',
            'client_blockstaircase',
            'client_floor',
            'client_door',
        ]);
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


    public function getClient($id)
    {
        $this->client = Client::with(['clientType', 'country'])->find($id);

        if ($this->client) {
            $this->dispatch('start-confirmation');
        }

    }

    public function closeProccess()
    {
        $this->switchAddressHandler();
        $this->changeCorrespondece();
        $this->form->reset();
        $this->selected_handler = 'getAddress';
        $this->fill([
            'inputs' => collect([['' => '']]),
        ]);
        $this->inputs->pull(0);
        $this->is_same_address = true;
    }

    public function save()
    {
        $this->validateData();

        if (count($this->form->serviceIds) == 0) {
            $this->dispatch('checks', title: "Datos faltantes", error: "Suministro requerido");
        } elseif ($this->selected_handler == 'getAddress' && empty($this->selectedAddressId)) {
            $this->dispatch('checks', title: "Datos faltantes", error: "Seleccione una dirección ");
        } elseif ($this->selected_handler == 'newAddress' && $this->isDuplicatedAddress()) {
            $this->dispatch('checks', title: "Direccion duplicada", error: "Existen una dirección igual para el mismo cliente");
        } else {
            DB::beginTransaction();

            try {

                if (in_array($this->fibra->id, $this->form->serviceIds)) {
                    //$this->emailRequest();
                }

                $this->folder = $this->getFolderName();

                if ($this->selected_handler == 'newAddress') {
                    $this->saveNewAddress();
                } elseif ($this->selected_handler == 'getAddress') {
                    $duplicated = $this->getFormalityDuplicated();
                    if (count($duplicated) !== 0) {
                        $msm = "Trámite ";
                        foreach ($duplicated as $value) {
                            $msm .= $value->service->name . ", ";
                        }
                        $msm = $msm . "ya existen en el sistema";
                        $this->dispatch('checks', title: "Trámite duplicado", error: $msm);
                        return;
                    } else {
                        $this->saveGetAddress();
                    }
                }

                $this->dispatch('created-confirmation');

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw CustomException::badRequestException($th->getMessage());
            }
        }


    }

    public function saveNewAddress()
    {
        if (count($this->form->serviceIds) > 0) {

            $address = Address::create($this->form->getCreateAddressDto());

            $this->createFormalityService->setClientId($this->client->id);
            $this->createFormalityService->setUserIssuerId(Auth::user()->id);
            $this->createFormalityService->setAddresId($address->id);


            $clientAddres = new Address();

            if (!$this->is_same_address) {
                $clientAddres = Address::create($this->form->getCreateClientAddressDto());
            } else {
                $clientAddres = Address::create($this->form->getCreateAddressDto());
            }

            $this->createFormalityService->setCorrespondenceAddressId($clientAddres->id);
            $this->client->update(['address_id' => $clientAddres->id]);

            $this->client->addresses()->attach([$clientAddres->id => ['iscorrespondence' => true], $address->id => ['iscorrespondence' => false]]);

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

                    $this->fileUploadigService->addExistingFile($this->client->files);
                }

            }


        }

    }

    public function saveGetAddress()
    {
        if (count($this->form->serviceIds) > 0) {

            $this->createFormalityService->setClientId($this->client->id);
            $this->createFormalityService->setUserIssuerId(Auth::user()->id);
            $this->createFormalityService->setAddresId($this->selectedAddressId);


            $clientAddres = new Address();
            if (!$this->is_same_address) {
                $clientAddres = Address::create($this->form->getCreateClientAddressDto());
            } else {
                $clientAddres = $this->getCorrespondenceAddress();
            }

            $this->createFormalityService->setCorrespondenceAddressId($clientAddres->id);
            //$this->client->update(['address_id' => $clientAddres->id]);


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

                    $this->fileUploadigService->addExistingFile($this->client->files);
                }

            }


        }
    }

    private function getCorrespondenceAddress()
    {
        $address = Address::where('id', $this->selectedAddressId)->first();

        $clientAddress = ClientAddress::whereHas('client', function ($query) use ($address) {
            $query->where('id', $this->client->id);
        })->whereHas('address', function ($query) use ($address) {
            $query->where('location_id', $address->location_id)
                ->where('street_type_id', $address->street_type_id)
                ->where('housing_type_id', $address->housing_type_id)
                ->where('street_name', $address->street_name)
                ->where('street_number', $address->street_number)
                ->where('zip_code', $address->zip_code)
                ->where('block', $address->block)
                ->where('block_staircase', $address->block_staircase)
                ->where('floor', $address->floor)
                ->where('door', $address->door);
        })->where('iscorrespondence', true)->first();
        if (!$clientAddress) {
            $newOne = Address::create($address->toArray());
            $this->client->addresses()->attach([$newOne->id => ['iscorrespondence' => true]]);
            return $newOne;
        } else {
            return $clientAddress->address;
        }

    }

    private function getFolderName(): string
    {
        return $this->client->files[0]->folder;
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
        $newdata = array_merge(['phone_code' => $this->selected_country->phone_code], /* $this->form->getClientDto() */);
        Mail::to(['jose.gomez@inmoenergy.es', 'inmobiliarias@inmoenergy.es'])
            ->send(new EmailLineaTelefonica($newdata, $this->form->getCreateAddressDto(), $attachs));

        $this->form->serviceIds = array_diff($this->form->serviceIds, [$this->fibra->id]);
    }

    public function validateData()
    {

        $rules = [
            'formalityTypeId' => 'required|exists:component_option,id',
            'serviceIds' => 'required|array|exists:component_option,id',
        ];

        $message = [
            'formalityTypeId.required' => 'Tipo de formulario es requerido',
            'serviceIds.required' => 'Servicio es requerido',
        ];

        if ($this->selected_handler == 'newAddress') {
            $rules['locationId'] = 'required|integer|exists:location,id';
            $rules['streetTypeId'] = 'required|integer|exists:component_option,id';
            $rules['housingTypeId'] = 'required|integer|exists:component_option,id';
            $rules['streetName'] = 'required|string';
            $rules['streetNumber'] = 'required|string';
            $rules['zipCode'] = 'required|string|spanish_postal_code';
            $rules['block'] = 'sometimes|nullable|string';
            $rules['blockstaircase'] = 'sometimes|nullable|string';
            $rules['floor'] = 'sometimes|nullable|string';
            $rules['door'] = 'sometimes|nullable|string';

            $rules['locationId.required'] = 'Locacion es requerido';
            $rules['streetTypeId.required'] = 'Tipo de calle es requerido';
            $rules['housingTypeId.required'] = 'Tipo de vivienda es requerido';
            $rules['streetName.required'] = 'Nombre de calle es requerido';
            $rules['streetNumber.required'] = 'N° de calle es requerido';
            $rules['zipCode.required'] = 'Codigo postal es requerido';
        }

        $this->form->validate($rules, $message);
        $this->validate();

    }

    public function getFormalityDuplicated()
    {
        return Formality::whereHas('client', function ($query) {
            $query->where('id', $this->client->id);
        })->whereHas('address', function ($query) {
            $query->where('id', $this->selectedAddressId);
        })->whereHas('service', function ($query) {
            $query->whereIn('id', $this->form->serviceIds);
        })->whereHas('status', function ($query) {
            $query->WhereIn('name', FormalityStatusNotDuplicated::getList());
        })->with('service')->get();
    }

    public function isDuplicatedAddress()
    {
        return ClientAddress::whereHas('client', function ($query) {
            $query->where('id', $this->client->id);
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


    public function canSearch(): bool
    {
        return !empty($this->search_full_name) || !empty($this->search_document_number) || !empty($this->search_client_type_id);
    }


    public function render()
    {
        $clientTypes = $this->userService->getClientTypes();

        $clients = [];

        $target_search_name = array('name', 'first_last_name', 'second_last_name');

        $query = Client::query();

        if ($this->canSearch()) {
            $targets = explode(' ', $this->search_full_name);


            foreach ($target_search_name as $index => $value) {
                if (isset($targets[$index]) && $targets[$index] !== '') {
                    $query->where($value, 'like', '%' . $targets[$index] . '%');
                }
            }

            if (!empty($this->search_document_number)) {
                $query->where('document_number', $this->search_document_number);
            }

            if (!empty($this->search_client_type_id)) {
                $query->where('client_type_id', $this->search_client_type_id);
            }

            $clients = $query->with(['clientType'])->paginate(10);
        }

        $formalitytypes = $this->formalityService->getFormalityTypes();
        $formalitytypes = $formalitytypes->where('name', '!=', 'renovación');
        $services = $this->formalityService->getServices();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();

        return view('livewire.formality.create-by-client', [
            'clients' => $clients,
            'clientTypes' => $clientTypes,
            'formalitytypes' => $formalitytypes,
            'services' => $services,
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
        ]);
    }
}
