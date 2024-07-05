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
    public $client_provinceId;
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

        $client = $formality->client;
        $clientdetail = $client->details;
        $address = $formality->address;
        $CorrespondenceAddress = $formality->CorrespondenceAddress;

        $this->formalityTypeId[0] = $formality->type->id;
        $this->serviceIds[0] = $formality->service->id;
        $this->clientTypeId = $clientdetail->clientType->id;
        $this->userTitleId = $clientdetail->title->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->firstLastName = $clientdetail->first_last_name;
        $this->secondLastName = $clientdetail->second_last_name;
        $this->documentTypeId = $clientdetail->documentType->id;
        $this->documentNumber = $clientdetail->document_number;
        $this->phone = $clientdetail->phone;
        $this->IBAN = $clientdetail->IBAN;
        $this->provinceId = $address->location->province->id;
        $this->locationId = $address->location->id;
        $this->streetTypeId = $address->streetType->id;
        $this->housingTypeId = $address->housingType->id;
        $this->streetName = $address->street_name;
        $this->streetNumber = $address->street_number;
        $this->zipCode = $address->zip_code;
        $this->block = $address->block;
        $this->blockstaircase = $address->block_staircase;
        $this->floor = $address->floor;
        $this->door = $address->door;

        $this->is_same_address = $formality->isSameCorrespondenceAddress;

        if (isset($CorrespondenceAddress)) {
            $this->client_provinceId = $CorrespondenceAddress->location->province->id;
            $this->client_locationId = $CorrespondenceAddress->location->id;
            $this->client_streetTypeId = $CorrespondenceAddress->streetType->id;
            $this->client_streetTypeId = $CorrespondenceAddress->streetType->id;
            $this->client_housingTypeId = $CorrespondenceAddress->housingType->id;
            $this->client_streetName = $CorrespondenceAddress->street_name;
            $this->client_streetNumber = $CorrespondenceAddress->street_number;
            $this->client_zipCode = $CorrespondenceAddress->zip_code;
            $this->client_block = $CorrespondenceAddress->block;
            $this->client_blockstaircase = $CorrespondenceAddress->block_staircase;
            $this->client_floor = $CorrespondenceAddress->floor;
            $this->client_door = $CorrespondenceAddress->door;

        }

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
        'email' => 'sometimes|nullable|email',
        'firstLastName' => 'sometimes|nullable|string',
        'secondLastName' => 'sometimes|nullable|string',
        'documentTypeId' => 'sometimes|nullable|integer|exists:document_type,id',
        'documentNumber' => 'sometimes|nullable|string',
        'phone' => 'sometimes|nullable|string',
        'clientTypeId' => 'sometimes|nullable|integer|exists:client_type,id',
        'userTitleId' => 'sometimes|nullable|integer|exists:user_title,id',
        'IBAN' => 'sometimes|nullable|string',
        'locationId' => 'sometimes|nullable|exists:location,id',
        'streetTypeId' => 'sometimes|nullable|exists:street_type,id',
        'housingTypeId' => 'sometimes|nullable|exists:housing_type,id',
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
