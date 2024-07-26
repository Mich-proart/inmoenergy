<?php

namespace App\Livewire;

use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Formality\Services\CreateFormalityService;
use App\Livewire\Forms\newFormalityFields;
use App\Models\ComponentOption;
use Livewire\Component;
use App\Domain\Address\Services\AddressService;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use DB;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;

class NewFormalityForm extends Component
{
    use WithFileUploads;

    public newFormalityFields $form;
    protected $addressService;
    protected $userService;
    protected $formalityService;
    protected $createFormalityService;

    public $target_provinceId;
    public $target_clientProvinceId;

    public $folder;

    public $file_fields = ['dni', 'factura_agua', 'factura_gas', 'factura_luz'];


    public $businessClientType;
    public $businessDocumentType;

    public $documentTypes;


    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->createFormalityService = App::make(CreateFormalityService::class);
        $this->folder = uniqid() . '_' . now()->timestamp;
        $this->businessClientType = ComponentOption::where('name', ClientTypeEnum::BUSINESS->value)->first();
        $this->businessDocumentType = ComponentOption::where('name', DocumentTypeEnum::CIF->value)->first();
    }


    public function mount()
    {
        $this->documentTypes = $this->userService->getDocumentTypes();
    }

    public function save()
    {

        $this->formValidation();

        DB::beginTransaction();

        try {

            $user = $this->userService->create($this->form->getCreateUserDto());

            $address = $this->addressService->createAddress($this->form->getCreateAddressDto());

            $this->createFormalityService->setClientId($user->id);
            $this->createFormalityService->setUserIssuerId(Auth::user()->id);
            $this->createFormalityService->setAddresId($address->id);

            if (!$this->form->is_same_address) {
                $clientAddres = $this->addressService->createAddress($this->form->getCreateClientAddressDto());
                $this->createFormalityService->setCorrespondenceAddressId($clientAddres->id);
                $this->createFormalityService->setIsSameCorrespondenceAddress(false);
                $user->update(['address_id' => $clientAddres->id]);
            }
            foreach ($this->form->serviceIds as $serviceId) {
                $this->createFormalityService->execute($serviceId, $this->form->formalityTypeId[0], $this->form->observation);
            }


            $fields = ['dni', 'factura_agua', 'factura_gas', 'factura_luz'];

            foreach ($fields as $field) {
                if ($this->form->$field) {
                    $this->userService
                        ->addFile($this->form->$field)
                        ->collesionFile($this->folder, $field);
                }
            }


            DB::commit();
            return redirect()->route('admin.formality.inprogress');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function updateDni()
    {
        $this->validateOnly($this->form->dni);
    }

    public function updateFacturaAgua()
    {
        $this->validateOnly($this->form->factura_agua);
    }

    public function updateFacturaGas()
    {
        $this->validateOnly($this->form->factura_gas);
    }
    public function updateFacturaLuz()
    {
        $this->validateOnly($this->form->factura_luz);
    }


    public function render()
    {
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        return view('livewire.new-formality-form', [
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
            'formalitytypes' => $formalitytypes,
            'services' => $services,
            'clientTypes' => $clientTypes,
            'userTitles' => $userTitles
        ]);
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
        $key = $clientProvince->where('name', 'Barcelona')->first();

        if ($key) {
            $this->target_provinceId = $key->id;
        }

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
        $this->form->validate();

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

}
