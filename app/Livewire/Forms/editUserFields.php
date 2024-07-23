<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Hash;

class editUserFields extends Form
{
    public bool $isWorker;

    public $name;
    public $email;
    public $firstLastName;
    public $secondLastName;
    public $documentTypeId;
    public $documentNumber;
    public $phone;
    public $password;

    public $clientTypeId;
    public $userTitleId;
    // public $IBAN;

    public $incentiveTypeTd;
    public $businessGroup;
    public $userOffice;
    public $adviserAssignedId;


    public $roleId;
    public $locationId;
    public $provinceId;
    public $streetTypeId;
    public $housingTypeId;
    public $streetName;
    public $streetNumber;
    public $zipCode;
    public $block;
    public $blockstaircase;
    public $floor;
    public $door;

    public function setUser($user)
    {

        $this->name = $user->name;
        $this->email = $user->email;
        $this->firstLastName = $user->first_last_name;
        $this->secondLastName = $user->second_last_name;
        $this->documentTypeId = $user->documentType->id ?? null;
        $this->documentNumber = $user->document_number;
        $this->phone = $user->phone;
        $this->clientTypeId = $user->clientType->id ?? null;
        $this->userTitleId = $user->title->id ?? null;
        $this->isWorker = $user->isWorker;
        // $this->IBAN = $user->IBAN;

        $this->incentiveTypeTd = $user->incentive->id ?? null;
        $this->businessGroup = $user->business_group;
        $this->userOffice = $user->user_office;
        $this->adviserAssignedId = $user->adviserAssigned->id ?? null;


        $this->roleId = $user->roles[0]->id ?? null;

        $address = $user->address;

        if ($address) {
            $this->locationId = $address->location->id;
            $this->provinceId = $address->location->province->id;
            $this->streetTypeId = $address->streetType->id;
            $this->housingTypeId = $address->housingType->id;
            $this->streetName = $address->street_name;
            $this->streetNumber = $address->street_number;
            $this->zipCode = $address->zip_code;
            $this->block = $address->block;
            $this->blockstaircase = $address->block_staircase;
            $this->floor = $address->floor;
            $this->door = $address->door;
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
        'clientTypeId' => 'required|integer|exists:component_option,id',
        'userTitleId' => 'required|integer|exists:component_option,id',
        'password' => 'sometimes|nullable|string|min:8',
        // 'IBAN' => 'sometimes|nullable|string',
        'incentiveTypeTd' => 'sometimes|nullable|integer|exists:component_option,id',
        'userOffice' => 'sometimes|nullable|string',
        'businessGroup' => 'sometimes|nullable|string',
        'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
        'roleId' => 'required|integer|exists:roles,id',
        'locationId' => 'required|integer|exists:location,id',
        'streetTypeId' => 'required|integer|exists:component_option,id',
        'housingTypeId' => 'required|integer|exists:component_option,id',
        'streetName' => 'required|string',
        'streetNumber' => 'required|string',
        'zipCode' => 'required|string|spanish_postal_code',
        'block' => 'sometimes|nullable|string',
        'blockstaircase' => 'sometimes|nullable|string',
        'floor' => 'sometimes|nullable|string',
        'door' => 'sometimes|nullable|string',
    ];

    protected $messages = [
        'email.unique' => 'El correo electronico ya se encuentra registrado',
        'email.email' => 'El correo electronico no es valido',
        'name.required' => 'El nombre es requerido',
        'documentTypeId.required' => 'El tipo de documento es requerido',
        'clientTypeId.required' => 'El tipo de cliente es requerido',
        'userTitleId.required' => 'El cargo es requerido',
        'password.min' => 'La contraseña debe ser al menos de 8 caracteres',
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
            'client_type_id' => $this->clientTypeId,
            'adviser_assigned_id' => $this->adviserAssignedId,
            'responsible_id' => auth()->user()->id,
            'user_title_id' => $this->userTitleId,
            'IBAN' => null,
            'incentive_type_id' => $this->incentiveTypeTd,
            'office_id' => $this->userOffice,
        ];

        if ($this->password != null) {
            $pass = hash::make($this->password);
            $data['password'] = $pass;
        }

        return $data;
    }

    public function getaddressUpdate()
    {
        return [
            'location_id' => $this->locationId,
            'street_type_id' => $this->streetTypeId,
            'housing_type_id' => $this->housingTypeId,
            'street_name' => $this->streetName,
            'street_number' => $this->streetNumber,
            'zip_code' => $this->zipCode,
            'block' => $this->block,
            'block_staircase' => $this->blockstaircase,
            'floor' => $this->floor,
            'door' => $this->door
        ];
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

}
