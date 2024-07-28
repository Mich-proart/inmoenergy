<?php

namespace App\Livewire\Forms;

use App\Domain\Address\Dtos\CreateAddressDto;
use App\Domain\User\Dtos\CreateUserDto;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Hash;

class newUserFormFields extends Form
{
    public bool $isWorker = false;
    public bool $isActive = true;

    public $name;
    public $email;
    public $firstLastName;
    public $secondLastName;
    public $documentTypeId;
    public $documentNumber;
    public $phone;
    public $password;

    // public $IBAN;

    public $incentiveTypeTd;
    public $businessGroup;
    public $officeId;
    public $adviserAssignedId;


    public $roleId;
    public $locationId;
    public $zipCode;



    public function setIsWorker(bool $isWorker)
    {
        $this->isWorker = $isWorker;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'firstLastName' => 'required|string',
        'secondLastName' => 'required|string',
        'documentTypeId' => 'required|integer|exists:component_option,id',
        'documentNumber' => 'required|string',
        'phone' => 'required|string|spanish_phone',
        'password' => 'required|string|min:8',
        'incentiveTypeTd' => 'sometimes|nullable|integer|exists:component_option,id',
        'officeId' => 'sometimes|nullable|integer|exists:office,id',
        // 'businessGroup' => 'sometimes|nullable|string',
        'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
        'roleId' => 'required|integer|exists:roles,id',
        'locationId' => 'required|integer|exists:location,id',
        'zipCode' => 'required|string|spanish_postal_code',
    ];

    protected $messages = [
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
        'phone.required' => 'El numero de telefono es requerido',
        'incentiveTypeTd.required' => 'El tipo de incentivo es requerido',
        'roleId.required' => 'El rol es requerido',
        'locationId.required' => 'La ubicacion es requerida',
        'zipCode.required' => 'El C.P. es requerido'
    ];

    public function getUserData()
    {
        $pass = Hash::make($this->password);
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $pass,
            'isWorker' => $this->isWorker,
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
            'phone' => $this->phone,
            'document_number' => $this->documentNumber,
            'document_type_id' => $this->documentTypeId,
            'client_type_id' => null,
            'adviser_assigned_id' => $this->adviserAssignedId,
            'responsible_id' => auth()->user()->id,
            'user_title_id' => null,
            'IBAN' => null,
            'incentive_type_id' => $this->incentiveTypeTd,
            'office_id' => $this->officeId,
            'isActive' => $this->isActive
        ];
    }

    public function getCreateAddressDto()
    {
        return [
            'location_id' => $this->locationId,
            'zip_code' => $this->zipCode
        ];
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

}
