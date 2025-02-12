<?php

namespace App\Livewire\User;

use App\Livewire\Forms\User\UserEdit;
use App\Models\BusinessGroup;
use App\Models\Country;
use App\Models\Office;
use Livewire\Component;
use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\editUserFields;
use App\Models\Address;
use App\Models\ComponentOption;
use App\Models\User;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class EditUserForm extends Component
{

    protected $addressService;
    protected $userService;

    public $target_provinceId;
    public $target_regionId;
    public $business_target;

    public $userId;

    public $isActive;

    public $user;

    public Country $selected_country;


    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
    }

    public UserEdit $form;

    public function generatePassword()
    {

        $this->form->setPassword(Str::password(20, true, true, true, false));
    }

    public function mount($user)
    {
        $this->user = $user;

        $this->form->setUser($this->user);
        $this->target_provinceId = $this->form->provinceId;
        $this->target_regionId = $this->form->regionId;
        $this->business_target = $user->office->businessGroup->id ?? null;
        $this->userId = $this->user->id;
        $this->isActive = $this->user->isActive;

        if ($user->country_id) {
            $this->changeCountry($user->country_id);
        } else {
            $country = Country::firstWhere('name', 'spain');
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

        $phoneRule = 'required|string|phone:' . $this->selected_country->iso2;
        $this->form->validate(
            [
                'phone' => $phoneRule,
                'name' => 'required|string',
                'email' => 'required|email',
                'firstLastName' => 'required|string',
                'secondLastName' => 'required|string',
                'documentTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
                'documentNumber' => 'sometimes|nullable|string',
                //'phone' => 'required|string|spanish_phone',
                'password' => 'sometimes|nullable|string|min:8',
                'incentiveTypeTd' => 'sometimes|nullable|integer|exists:component_option,id',

                'businessGroup' => 'sometimes|nullable|string',
                'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
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
                'email.unique' => 'El correo electronico ya se encuentra registrado',
                'email.email' => 'El correo electronico no es valido',
                'name.required' => 'El nombre es requerido',
                'documentTypeId.required' => 'El tipo de documento es requerido',
                'password.min' => 'La contraseña debe ser al menos de 8 caracteres',
                'password.string' => 'La contraseña debe ser una cadena de caracteres',
                'email.required' => 'El correo electronico es requerido',
                'documentNumber.required' => 'El numero de documento es requerido',
                'locationId.required' => 'La ubicacion es requerida',
                'zipCode.spanish_postal_code' => 'El Código Postal no es valido',
                'zipCode.required' => 'El Código Postal es requerido',
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
                // 'officeId' => 'required|integer|exists:office,id',
                // 'responsibleId' => 'required|integer|exists:users,id',
                'officeName' => 'required|string',
                'responsibleName' => 'required|string',
                'adviserAssignedId' => 'required|integer|exists:users,id',
                'incentiveTypeTd' => 'required|integer|exists:component_option,id',
            ], [
                //'officeId.required' => 'El campo Oficina es obligatorio',
                //'responsibleId.required' => 'El campo Responsable es obligatorio',
                'officeName.required' => 'El campo Oficina es obligatorio',
                'responsibleName.required' => 'El campo Responsable es obligatorio',
                'adviserAssignedId.required' => 'El campo Asesor Asignado es obligatorio',
                'incentiveTypeTd.required' => 'El campo Tipo de incentivo es obligatorio',
            ]);

        }

        if (!$this->form->isActive) {
            $this->form->validate(
                [
                    'disabledAt' => 'required|date'
                ],
                [
                    'disabledAt.required' => 'El campo Fecha de baja es obligatorio',
                ]
            );
        }

        if (!$this->form->isWorker && ($this->business_target == null || $this->business_target == '' || $this->business_target == 0)) {
            $this->dispatch('msg', error: "Por favor, Seleccione un grupo empresarial", title: "Dato incompleto", type: "error");
        } elseif (!$this->user->isActive && $this->form->isActive) {
            if ($this->form->password == null || $this->form->password == '') {
                $this->dispatch('msg', error: "Por favor, proporcione una contraseña de acceso", title: "Activación de usuario", type: "warning");
            } else {
                $this->exucuteSave();
            }
        } else {
            $this->exucuteSave();
        }


    }


    public function exucuteSave()
    {
        DB::beginTransaction();

        try {
            $updates = array_merge(
                ['country_id' => $this->selected_country->id],
                $this->form->getclientUpdate()
            );
            if (!$this->form->isWorker && $this->user->office != null && $this->form->officeName != null) {
                $this->user->office()->update([
                    'name' => strtolower($this->form->officeName),
                    'business_group_id' => $this->business_target
                ]);
            }

            $data = User::where('id', $this->userId)->with('address')->first();
            $data->update($updates);

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
        $roles = $this->userService->getRoles();
        $incentiveTypes = $this->userService->getIncentiveTypes();
        $advisers = User::where('isWorker', 1)->get();
        $countries = Country::all();
        return view('livewire.user.edit-user-form', compact([
            'documentTypes',
            'roles',
            'incentiveTypes',
            'advisers',
            'countries'
        ]));
    }

    public function changeStatus()
    {
        $this->isActive = !$this->isActive;
        if ($this->form->isActive) {
            $this->form->disabledAt = null;
        }
    }
}
