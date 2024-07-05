<?php

namespace App\Livewire;

use App\Domain\Address\Services\AddressService;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\updateFormalityFields;
use App\Models\Address;
use App\Models\Formality;
use App\Models\StreetType;
use App\Models\UserDetail;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\Computed;

class EditFormality extends Component
{
    protected $formalityService;
    protected $addressService;
    protected $userService;

    // fields
    public updateFormalityFields $form;
    public int $formalityId;
    public $formality;

    public $target_provinceId;
    public $target_clientProvinceId;



    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);
    }



    public function mount($formalityId)
    {
        $this->formalityId = $formalityId;
        $this->formality = $this->formalityService->getById($formalityId);
        $this->form->setformality($this->formality);
        $this->target_provinceId = $this->form->provinceId;
        $this->target_clientProvinceId = $this->form->client_provinceId;
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
        return view('livewire.edit-formality', compact(['streetTypes', 'housingTypes', 'formalitytypes', 'services', 'documentTypes', 'clientTypes', 'userTitles']));
    }

    public function update()
    {

        $this->form->validate();


        DB::beginTransaction();

        try {

            $data = Formality::firstWhere('id', $this->formalityId);
            $data->client()->update($this->form->getclientUpdate());

            $details = UserDetail::firstWhere('user_id', $data->client->id);
            $details->update($this->form->getDetailsUpdate());

            $address = Address::firstWhere('id', $data->address->id);
            $address->update($this->form->getaddressUpdate());

            if ($data->CorrespondenceAddress !== null) {
                $corresponceAddress = Address::firstWhere('id', $data->CorrespondenceAddress->id);
                $corresponceAddress->update($this->form->getCorresponceAddressUpdate());
            }

            $data->update($this->form->getFormalityUpdate());

            $data->save();

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
}
