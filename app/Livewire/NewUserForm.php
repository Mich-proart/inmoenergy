<?php

namespace App\Livewire;

use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Formality\Services\CreateFormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\newUserFormFields;
use App\Models\Address;
use App\Models\BusinessGroup;
use App\Models\ComponentOption;
use App\Models\Office;
use App\Models\User;
use Livewire\Component;
use DB;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class NewUserForm extends Component
{
    public $target_provinceId;

    public $business_target;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
        $this->createFormalityService = App::make(CreateFormalityService::class);
        $this->folder = uniqid() . '_' . now()->timestamp;
    }


    public newUserFormFields $form;

    public function mount(bool $isWorker = false)
    {
        $this->form->setIsWorker($isWorker);
    }

    public function generatePassword()
    {

        $this->form->setPassword(Str::password(20, true, true, true, false));
    }
    public function render()
    {
        $documentTypes = $this->userService->getDocumentTypes();
        $documentTypes = $documentTypes->where('name', '!=', DocumentTypeEnum::CIF->value);
        $roles = $this->userService->getRoles();
        $incentiveTypes = $this->userService->getIncentiveTypes();
        $advisers = User::where('isWorker', 1)->where('isActive', 1)->get();
        return view('livewire.new-user-form', compact([
            'documentTypes',
            'roles',
            'incentiveTypes',
            'advisers'
        ]));
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


        $selectedDocumentType = ComponentOption::where('id', $this->form->documentTypeId)->first();

        $rule = '';
        if ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::PASSPORT->value) {
            $rule = 'required|string|min:9|max:9';
        } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::DNI->value) {
            $rule = DocumentRule::$DNI;
        } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::NIE->value) {
            $rule = DocumentRule::$NIE;
        }

        $this->form->validate([
            'documentNumber' => $rule
        ]);

        DB::beginTransaction();

        try {
            $user = User::create($this->form->getUserData());

            $role = Role::firstWhere('id', $this->form->getRoleId());

            $user->assignRole($role);

            $address = Address::create($this->form->getCreateAddressDto());
            $user->update(['address_id' => $address->id]);

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
    #[Computed()]
    public function business()
    {
        $businessGroup = BusinessGroup::all();
        return $businessGroup;
    }
    #[Computed()]
    public function offices()
    {
        $offices = Office::where('business_group_id', $this->business_target)->get();
        return $offices;
    }

}
