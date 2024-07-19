<?php

namespace App\Livewire;

use App\Domain\Address\Services\AddressService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\editUserFields;
use App\Models\Address;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class EditUser extends Component
{

    protected $addressService;
    protected $userService;

    public $target_provinceId;

    public $userId;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
    }

    public editUserFields $form;

    public function render()
    {
        $documentTypes = $this->userService->getDocumentTypes();
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        $roles = $this->userService->getRoles();
        $incentiveTypes = $this->userService->getIncentiveTypes();
        $advisers = User::where('isWorker', 1)->get();
        return view('livewire.edit-user', compact([
            'documentTypes',
            'clientTypes',
            'userTitles',
            'streetTypes',
            'housingTypes',
            'roles',
            'incentiveTypes',
            'advisers',
        ]));
    }

    public function generatePassword()
    {

        $this->form->setPassword(Str::password(20, true, true, true, false));
    }

    public function mount($userId)
    {
        $user = $this->userService->getById($userId);

        $this->form->setUser($user);
        $this->target_provinceId = $this->form->provinceId;
        $this->userId = $userId;
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

    public function save()
    {

        $this->form->validate();

        DB::beginTransaction();

        try {

            $data = User::where('id', $this->userId)->with('address')->first();
            $data->update($this->form->getclientUpdate());

            DB::table('model_has_roles')->where('model_id', $data->id)->delete();

            $role = Role::firstWhere('id', $this->form->getRoleId());

            $data->assignRole($role);

            if ($data->address) {
                $data->address->update($this->form->getaddressUpdate());
            }


            DB::commit();

            if ($this->form->isWorker == true) {
                return redirect()->route('admin.users');
            } else {
                return redirect()->route('admin.clients');
            }

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }
}
