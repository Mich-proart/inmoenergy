<?php

namespace App\Livewire\Forms\User;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Hash;

class UserEdit extends Form
{
    public bool $isWorker;

    public bool $isActive;

    public $name;
    public $email;
    public $firstLastName;
    public $secondLastName;
    public $documentTypeId;
    public $documentNumber;
    public $phone;
    public $password;

    public $incentiveTypeTd;
    public $businessGroup;
    public $userOffice;
    public $adviserAssignedId;
    public $officeId;

    public $roleId;
    public $locationId;
    public $provinceId;
    public $regionId;
    public $zipCode;

    public $responsibleId;
    public $full_address;

    public $disabledAt;


    public function setUser($user)
    {

        $this->name = $user->name;
        $this->email = $user->email;
        $this->firstLastName = $user->first_last_name;
        $this->secondLastName = $user->second_last_name;
        $this->documentTypeId = $user->documentType->id ?? null;
        $this->documentNumber = $user->document_number;
        $this->phone = $user->phone;
        $this->isWorker = $user->isWorker;
        // $this->IBAN = $user->IBAN;

        $this->incentiveTypeTd = $user->incentive->id ?? null;
        $this->businessGroup = $user->business_group;
        $this->officeId = $user->office->id ?? null;
        $this->adviserAssignedId = $user->adviserAssigned->id ?? null;
        $this->responsibleId = $user->responsible->id ?? null;


        $this->roleId = $user->roles[0]->id ?? null;

        $address = $user->address;

        if ($address) {
            $this->locationId = $address->location->id;
            $this->provinceId = $address->location->province->id;
            $this->regionId = $address->location->province->region->id;
            $this->zipCode = $address->zip_code;
            $this->full_address = $address->full_address;
        }

        $this->isActive = $user->isActive;

        if ($user->disabled_at) {
            $this->disabledAt = date('Y-m-d', strtotime($user->disabled_at));
        }

    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'firstLastName' => 'required|string',
        'secondLastName' => 'required|string',
        'documentTypeId' => 'required|integer|exists:component_option,id',
        'documentNumber' => 'required|string',
        'phone' => 'required|string|spanish_phone',
        'password' => 'sometimes|nullable|string|min:8',
        'incentiveTypeTd' => 'sometimes|nullable|integer|exists:component_option,id',

        'businessGroup' => 'sometimes|nullable|string',
        'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
        'roleId' => 'required|integer|exists:roles,id',
        'locationId' => 'required|integer|exists:location,id',
        'zipCode' => 'required|string|spanish_postal_code',
        'full_address' => 'required|string',
    ];

    protected $messages = [
        'email.unique' => 'El correo electronico ya se encuentra registrado',
        'email.email' => 'El correo electronico no es valido',
        'name.required' => 'El nombre es requerido',
        'documentTypeId.required' => 'El tipo de documento es requerido',
        'password.min' => 'La contraseña debe ser al menos de 8 caracteres',
        'password.string' => 'La contraseña debe ser una cadena de caracteres',
        'email.required' => 'El correo electronico es requerido',
        'documentNumber.required' => 'El numero de documento es requerido',
        'phone.spanish_phone' => 'El numero de telefono no es valido',
        'phone.required' => 'El numero de telefono es requerido',
        'locationId.required' => 'La ubicacion es requerida',
        'zipCode.spanish_postal_code' => 'El Código Postal no es valido',
        'zipCode.required' => 'El Código Postal es requerido',
        'full_address.required' => 'La dirección es requerida',
    ];

    public function getclientUpdate()
    {

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'isWorker' => $this->isWorker,
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
            'phone' => $this->phone,
            'document_number' => $this->documentNumber,
            'document_type_id' => $this->documentTypeId,
            'adviser_assigned_id' => $this->adviserAssignedId,
            'responsible_id' => $this->responsibleId,
            'incentive_type_id' => $this->incentiveTypeTd,
            'office_id' => $this->officeId,
            'isActive' => $this->isActive,
            'disabled_at' => $this->disabledAt
        ];

        if ($this->password != null) {
            $pass = hash::make($this->password);
            $data['password'] = $pass;
        }

        if (!$this->isActive) {
            $pass = hash::make('notActive');
            $data['password'] = $pass;
        }

        return $data;
    }

    public function getaddressUpdate()
    {
        return [
            'full_address' => $this->full_address,
            'location_id' => $this->locationId,
            'zip_code' => $this->zipCode
        ];
    }

    public function getRoleId()
    {
        return $this->roleId;
    }
}
