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
use App\Models\StreetType;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;

class NewFormalityForm extends Component
{

    public newFormalityFields $form;
    protected $addressService;
    protected $userService;
    protected $formalityService;
    protected $createFormalityService;

    public $target_provinceId;
    public $target_clientProvinceId;



    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
        $this->createFormalityService = App::make(CreateFormalityService::class);
    }

    public function save()
    {

        $this->form->validate();

        DB::beginTransaction();

        try {

            $user = $this->userService->create($this->form->getCreateUserDto());

            $address = $this->addressService->createAddress($this->form->getCreateAddressDto());
            $userdetails = $this->form->getCreatUserDetailDto();
            $userdetails->setUserId($user->id);
            $userdetails->setAddressId($address->id);

            if (!$this->form->is_same_address) {
                $clientAddres = $this->addressService->createAddress($this->form->getCreateClientAddressDto());
                $userdetails->setAddressId($clientAddres->id);
            }

            $this->userService->setUserDetails($userdetails);


            $this->createFormalityService->setClientId($user->id);
            $this->createFormalityService->setUserIssuerId(Auth::user()->id);
            $this->createFormalityService->setAddresId($address->id);

            foreach ($this->form->serviceIds as $serviceId) {
                $this->createFormalityService->execute($serviceId, $this->form->formalityTypeId[0], $this->form->observation);
            }

            DB::commit();
            return redirect()->route('admin.formality.inprogress');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function render()
    {
        $documentTypes = $this->userService->getDocumentTypes();
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $streetTypes = StreetType::all();
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