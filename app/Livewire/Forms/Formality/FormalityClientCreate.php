<?php

namespace App\Livewire\Forms\Formality;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityClientCreate extends Form
{
    public $formalityTypeId = [];
    public $serviceIds = [];

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

    public $is_same_address = true;
    public $observation;


    public function getCreateAddressDto()
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
            'door' => $this->door,
        ];
    }

    public function getCreateClientAddressDto()
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
            'door' => $this->client_door,
        ];
    }
}
