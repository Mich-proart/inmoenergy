<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class updateFormalityFields extends Form
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

    public $provinceId;
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

    public bool $is_same_address;

    public $issuer_observation;
    public $observation;

    public function setformality($formality)
    {

        $this->formalityTypeId[0] = $formality->formalityTypeId;
        $this->serviceIds[0] = $formality->serviceId;
        $this->clientTypeId = $formality->clientTypeId;
        $this->userTitleId = $formality->userTitleId;
        $this->name = $formality->name;
        $this->email = $formality->email;
        $this->firstLastName = $formality->firstLastName;
        $this->secondLastName = $formality->secondLastName;
        $this->documentTypeId = $formality->documentTypeId;
        $this->documentNumber = $formality->documentNumber;
        $this->phone = $formality->phone;
        $this->IBAN = $formality->IBAN;
        $this->provinceId = $formality->provinceId;
        $this->locationId = $formality->locationId;
        $this->streetTypeId = $formality->streetTypeId;
        $this->housingTypeId = $formality->housingTypeId;
        $this->streetName = $formality->streetName;
        $this->streetNumber = $formality->streetNumber;
        $this->zipCode = $formality->zipCode;
        $this->block = $formality->block;
        $this->blockstaircase = $formality->blockstaircase;
        $this->floor = $formality->floor;
        $this->door = $formality->door;

        $this->is_same_address = $formality->isSameCorrespondenceAddress;

        $this->client_locationId = $formality->client_locationId;
        $this->client_streetTypeId = $formality->client_streetTypeId;
        $this->client_streetTypeId = $formality->client_streetTypeId;
        $this->client_housingTypeId = $formality->client_housingTypeId;
        $this->client_streetName = $formality->client_streetName;
        $this->client_streetNumber = $formality->client_streetNumber;
        $this->client_zipCode = $formality->client_zipCode;
        $this->client_block = $formality->client_block;
        $this->client_blockstaircase = $formality->client_blockstaircase;
        $this->client_floor = $formality->client_floor;
        $this->client_door = $formality->client_door;

        $this->issuer_observation = $formality->issuer_observation;
        $this->observation = $formality->observation;


    }

    public function getclientUpdate()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
    public function getDetailsUpdate()
    {
        return [
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
            'phone' => $this->phone,
            'document_number' => $this->documentNumber,
            'document_type_id' => $this->documentTypeId,
            'IBAN' => $this->IBAN
        ];
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
    public function getCorresponceAddressUpdate()
    {
        return [
            'location_id' => $this->client_locationId,
            'street_type_id' => $this->client_streetTypeId,
            'housing_type_id' => $this->client_housingTypeId,
            'street_name' => $this->client_streetName,
            'street_number' => $this->client_streetNumber,
            'zip_code' => $this->client_zipCode,
            'block' => $this->client_block,
            'block_staircase' => $this->client_blockstaircase,
            'floor' => $this->client_floor,
            'door' => $this->client_door
        ];
    }

    public function getFormalityUpdate()
    {
        return [
            'service_id' => $this->serviceIds[0],
            'observation' => $this->observation,
            'formality_type_id' => $this->formalityTypeId[0],
        ];
    }

    protected $rules = [
        'formalityTypeId' => 'sometimes|nullable|exists:formality_type,id',
        'serviceIds' => 'sometimes|nullable|array|exists:service,id',
        'name' => 'sometimes|nullable|string',
        'email' => 'sometimes|nullable|email|unique:users,email',
        'firstLastName' => 'sometimes|nullable|string',
        'secondLastName' => 'sometimes|nullable|string',
        'documentTypeId' => 'sometimes|nullable|integer|exists:document_type,id',
        'documentNumber' => 'sometimes|nullable|string',
        'phone' => 'sometimes|nullable|string',
        'clientTypeId' => 'sometimes|nullable|integer|exists:client_type,id',
        'userTitleId' => 'sometimes|nullable|integer|exists:user_title,id',
        'IBAN' => 'sometimes|nullable|string',
        'locationId' => 'requiredsometimes|nullable|exists:location,id',
        'streetTypeId' => 'requiredsometimes|nullable|exists:street_type,id',
        'housingTypeId' => 'requiredsometimes|nullable|exists:housing_type,id',
        'streetName' => 'sometimes|nullable|string',
        'streetNumber' => 'sometimes|nullable|string',
        'zipCode' => 'sometimes|nullable|string',
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
        'observation' => 'sometimes|nullable|string|max:255'
    ];
}
