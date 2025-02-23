<?php

namespace App\Livewire\User;

use App\Livewire\Forms\User\UserCreate;
use App\Models\Country;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
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

    public $office_list = [];

    public $officeId;

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
        $this->resetErrorBag();
        $phoneRule = 'required|string|phone:' . $this->selected_country->iso2;
        $this->form->validate(
            [
                'phone' => $phoneRule,
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'firstLastName' => 'required|string',
                'secondLastName' => 'required|string',
                'documentTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
                'documentNumber' => 'sometimes|nullable|string',
                'password' => 'required|string|min:8',
                'incentiveTypeTd' => 'sometimes|nullable|integer|exists:component_option,id',
                'officeId' => 'sometimes|nullable|integer|exists:office,id',
                'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
                'responsibleId' => 'sometimes|nullable|integer|exists:users,id',
                'roleId' => 'required|integer|exists:roles,id',
                'locationId' => 'required|integer|exists:location,id',
                'zipCode' => 'required|string|spanish_postal_code',
                'full_address' => 'required|string',
            ],
            [
                'phone.min' => 'El campo debe ser un telefono valido.',
                'phone.max' => 'El campo debe ser un telefono valido.',
                'phone.required' => 'El campo es requerido.',
                'phone.phone' => 'El campo debe ser un telefono valido.',
                'name.required' => 'El nombre es requerido',
                'email.unique' => 'El correo electronico ya se encuentra registrado',
                'email.email' => 'El correo electronico no es valido',
                'email.required' => 'El correo electronico es requerido',
                'password.string' => 'La contraseña debe ser una cadena de caracteres',
                'phone.spanish_phone' => 'El numero de telefono no es valido',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.required' => 'La contraseña es requerida',
                'firstLastName.required' => 'El primer apellido es requerido',
                'secondLastName.required' => 'El segundo apellido es requerido',
                'documentTypeId.required' => 'El tipo de documento es requerido',
                'documentNumber.required' => 'El numero de documento es requerido',
                'incentiveTypeTd.required' => 'El tipo de incentivo es requerido',
                'roleId.required' => 'El rol es requerido',
                'locationId.required' => 'La ubicacion es requerida',
                'zipCode.required' => 'El C.P. es requerido',
                'full_address.required' => 'La dirección es requerida',
            ]
        );

        if ($this->form->documentTypeId) {
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
        }

        if (!$this->form->isWorker) {
            $this->form->validate([
                //'officeId' => 'required',
                //'responsibleId' => 'required|integer|exists:users,id',
                // 'officeName' => 'required|string',
                'responsibleName' => 'required|string',
                'adviserAssignedId' => 'required|integer|exists:users,id',
                'incentiveTypeTd' => 'required|integer|exists:component_option,id',
            ], [
                //'officeId.required' => 'El campo Oficina es obligatorio',
                // 'responsibleId.required' => 'El campo Responsable es obligatorio',
                //'officeName.required' => 'El campo Oficina es obligatorio',
                'responsibleName.required' => 'El campo Responsable es obligatorio',
                'adviserAssignedId.required' => 'El campo Asesor Asignado es obligatorio',
                'incentiveTypeTd.required' => 'El campo Tipo de incentivo es obligatorio',
            ]);

            $this->validate([
                'business_target' => 'required|integer|exists:business_group,id',
                'officeId' => 'required'
            ], [
                'business_target.required' => 'El campo es obligatorio',
                'officeId.required' => 'El campo Oficina es obligatorio',
            ]);
        }

        DB::beginTransaction();

        try {

            $updates = array_merge($this->form->getUserData());
            $updates['country_id'] = $this->selected_country->id;
            if (!$this->form->isWorker) {
                $office = Office::firstWhere([
                    'id' => $this->officeId
                ]);

                if (!$office) {
                    $office = Office::create([
                        'name' => strtolower($this->officeId),
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



    #[On('change-businessGroup')]
    public function changeBusinessGroup()
    {
        $this->office_list = Office::where('business_group_id', $this->business_target)->get();
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
