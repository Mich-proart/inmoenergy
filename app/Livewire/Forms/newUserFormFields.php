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
    public $streetTypeId;
    public $housingTypeId;
    public $streetName;
    public $streetNumber;
    public $zipCode;
    public $block;
    public $blockstaircase;
    public $floor;
    public $door;

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
        'documentTypeId' => 'required|integer|exists:document_type,id',
        'documentNumber' => 'required|string',
        'phone' => 'required|string',
        'clientTypeId' => 'required|integer|exists:client_type,id',
        'userTitleId' => 'required|integer|exists:user_title,id',
        'password' => 'required|string|min:8',
        // 'IBAN' => 'required|string',
        'incentiveTypeTd' => 'sometimes|nullable|integer|exists:incentive_type,id',
        'businessGroup' => 'sometimes|nullable|string',
        'userOffice' => 'sometimes|nullable|string',
        'adviserAssignedId' => 'sometimes|nullable|integer|exists:users,id',
        'roleId' => 'required|integer|exists:roles,id',
        'locationId' => 'required|integer|exists:location,id',
        'streetTypeId' => 'required|integer|exists:street_type,id',
        'housingTypeId' => 'required|integer|exists:housing_type,id',
        'streetName' => 'required|string',
        'streetNumber' => 'required|string',
        'zipCode' => 'required|string',
        'block' => 'sometimes|nullable|string',
        'blockstaircase' => 'sometimes|nullable|string',
        'floor' => 'sometimes|nullable|string',
        'door' => 'sometimes|nullable|string',
    ];

    public function getCreateUserDto(): CreateUserDto
    {
        $pass = Hash::make($this->password);
        return new CreateUserDto(
            $this->name,
            $this->email,
            $pass,
            $this->isWorker,
            $this->firstLastName,
            $this->secondLastName,
            $this->documentTypeId,
            $this->documentNumber,
            $this->phone,
            $this->clientTypeId,
            $this->userTitleId,
            null,
            null,
            null,
        );
    }

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
            'client_type_id' => $this->clientTypeId,
            'adviser_assigned_id' => $this->adviserAssignedId,
            'responsible_id' => auth()->user()->id,
            'user_title_id' => $this->userTitleId,
            'IBAN' => null,
            'incentive_type_id' => $this->incentiveTypeTd,
            'business_group' => $this->businessGroup,
            'user_office' => $this->userOffice,
        ];
    }

    public function getCreateAddressDto(): CreateAddressDto
    {
        return new CreateAddressDto(
            $this->locationId,
            $this->streetTypeId,
            $this->housingTypeId,
            $this->streetName,
            $this->streetNumber,
            $this->zipCode,
            $this->block,
            $this->blockstaircase,
            $this->floor,
            $this->door
        );
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

}
