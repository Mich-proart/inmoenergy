<?php

namespace App\Livewire\User;

use App\Livewire\Forms\User\UserCreate;
use App\Models\Country;
use Livewire\Component;
use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Models\Address;
use App\Models\BusinessGroup;
use App\Models\ComponentOption;
use App\Models\Office;
use App\Models\User;
use DB;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CreateUserForm extends Component
{

    public $target_provinceId;
    public $target_regionId;

    public $business_target;

    public Country $selected_country;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
        $this->folder = uniqid() . '_' . now()->timestamp;
    }
    public UserCreate $form;

    public function mount(bool $isWorker = false)
    {
        $this->form->setIsWorker($isWorker);

        $country = Country::firstWhere('name', 'spain');

        if ($country) {
            $this->selected_country = $country;
        }
    }

    public function changeCountry($id)
    {
        $country = Country::firstWhere('id', $id);
        if ($country) {
            $this->selected_country = $country;
        }
    }

    public function generatePassword()
    {

        $this->form->setPassword(Str::password(20, true, true, true, false));
    }

    #[Computed()]

    public function regions()
    {
        $regions = $this->addressService->getRegions();
        return $regions;
    }
    #[Computed()]

    public function provinces()
    {
        $province = $this->addressService->getProvinces((int) $this->target_regionId);
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

        if (!$this->form->isWorker) {
            $this->form->validate([
                // 'officeId' => 'required|integer|exists:office,id',
                //'responsibleId' => 'required|integer|exists:users,id',
                'officeName' => 'required|string',
                'responsibleName' => 'required|string',
                'adviserAssignedId' => 'required|integer|exists:users,id',
                'incentiveTypeTd' => 'required|integer|exists:component_option,id',
            ], [
                // 'officeId.required' => 'El campo Oficina es obligatorio',
                // 'responsibleId.required' => 'El campo Responsable es obligatorio',
                'officeName.required' => 'El campo Oficina es obligatorio',
                'responsibleName.required' => 'El campo Responsable es obligatorio',
                'adviserAssignedId.required' => 'El campo Asesor Asignado es obligatorio',
                'incentiveTypeTd.required' => 'El campo Tipo de incentivo es obligatorio',
            ]);

        }

        DB::beginTransaction();

        try {

            $updates = array_merge($this->form->getUserData());
            $updates['country_id'] = $this->selected_country->id;
            if (!$this->form->isWorker) {
                $office = Office::firstWhere([
                    'name' => strtolower($this->form->officeName),
                    'business_group_id' => $this->business_target,
                ]);

                if (!$office) {
                    $office = Office::create([
                        'name' => strtolower($this->form->officeName),
                        'business_group_id' => $this->business_target,
                    ]);
                }
                $updates['office_id'] = $office->id;
            }

            $user = User::create($updates);

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

    public function render()
    {
        $documentTypes = $this->userService->getDocumentTypes();
        $documentTypes = $documentTypes->where('name', '!=', DocumentTypeEnum::CIF->value);
        $documentTypes = $documentTypes->where('name', '!=', 'pasaporte');
        $roles = $this->userService->getRoles();
        $incentiveTypes = $this->userService->getIncentiveTypes();
        $advisers = User::where('isWorker', 1)->where('isActive', 1)->get();
        $countries = Country::all();
        return view('livewire.user.create-user-form', compact([
            'documentTypes',
            'roles',
            'incentiveTypes',
            'advisers',
            'countries'
        ]));
    }
}
