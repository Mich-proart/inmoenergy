<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Domain\Address\Dtos\CreateAddressDto;
use App\Domain\User\Dtos\CreateUserDetailDto;
use App\Domain\User\Dtos\CreateUserDto;
use Hash;

class newFormalityFields extends Form
{
    public $formalityTypeId = [];
    public $serviceIds = [];

    public $clientTypeId;
    public $userTitleId;
    public $name;
    public $email;
    public $firstLastName;
    public $secondLastName;
    public $documentTypeId;
    public $documentNumber;
    public $phone;
    public $IBAN;
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

    public $client_locationId;
    public $client_streetTypeId;
    public $client_housingTypeId;
    public $client_streetName;
    public $client_streetNumber;
    public $client_zipCode;
    public $client_block;
    public $client_blockstaircase;
    public $client_floor;
    public $client_door;

    public $is_same_address = false;
    public $observation;

    protected $rules = [
        'formalityTypeId' => 'required|exists:formality_type,id',
        'serviceIds' => 'required|array|exists:service,id',
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'firstLastName' => 'required|string',
        'secondLastName' => 'sometimes|nullable|string',
        'documentTypeId' => 'required|integer|exists:document_type,id',
        'documentNumber' => 'required|string',
        'phone' => 'required|string',
        'clientTypeId' => 'required|integer|exists:client_type,id',
        'userTitleId' => 'required|integer|exists:user_title,id',
        'IBAN' => 'required|string',
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
        'client_locationId' => 'sometimes|nullable|integer|exists:location,id',
        'client_streetTypeId' => 'sometimes|nullable|integer|exists:street_type,id',
        'client_housingTypeId' => 'sometimes|nullable|integer|exists:housing_type,id',
        'client_streetName' => 'sometimes|nullable|string',
        'client_streetNumber' => 'sometimes|nullable|string',
        'client_zipCode' => 'sometimes|nullable|string',
        'client_block' => 'sometimes|nullable|string',
        'client_blockstaircase' => 'sometimes|nullable|string',
        'client_floor' => 'sometimes|nullable|string',
        'client_door' => 'sometimes|nullable|string',
        'observation' => 'sometimes|nullable|string|max:255',
    ];

    public function getCreateUserDto(): CreateUserDto
    {
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        return new CreateUserDto(
            $this->name,
            $this->email,
            Hash::make($pass),
            false
        );
    }

    public function getCreatUserDetailDto(): CreateUserDetailDto
    {
        return new CreateUserDetailDto(
            $this->firstLastName,
            $this->secondLastName,
            $this->documentTypeId,
            $this->documentNumber,
            $this->phone,
            $this->clientTypeId,
            $this->userTitleId,
            $this->IBAN,
            null,
            null,
        );
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

    public function getCreateClientAddressDto(): CreateAddressDto
    {
        return new CreateAddressDto(
            $this->client_locationId,
            $this->client_streetTypeId,
            $this->client_housingTypeId,
            $this->client_streetName,
            $this->client_streetNumber,
            $this->client_zipCode,
            $this->client_block,
            $this->client_blockstaircase,
            $this->client_floor,
            $this->client_door
        );
    }
}
