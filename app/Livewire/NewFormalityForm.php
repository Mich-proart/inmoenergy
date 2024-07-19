<?php

namespace App\Livewire;

use App\Domain\Formality\Services\CreateFormalityService;
use App\Livewire\Forms\newFormalityFields;
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



    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->createFormalityService = App::make(CreateFormalityService::class);
        $this->folder = uniqid() . '_' . now()->timestamp;
    }

    public function save()
    {

        $this->form->validate();

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

            /*
            $fields = ['dni', 'factura_agua', 'factura_gas', 'factura_luz'];

            foreach ($fields as $field) {
                if ($this->form->$field) {
                    $this->userService
                        ->addFile($this->form->$field)
                        ->collesionFile($this->folder, $field);
                }
            }
            */

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
        $documentTypes = $this->userService->getDocumentTypes();
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        return view('livewire.new-formality-form', compact(['streetTypes', 'housingTypes', 'formalitytypes', 'services', 'documentTypes', 'clientTypes', 'userTitles']));
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
}
