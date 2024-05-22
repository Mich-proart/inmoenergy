<?php

namespace App\Dto\Address;

class CreateAddressDto
{
    public string $locationId;
    public string $streetTypeId;
    public string $streetName;
    public string $streetNumber;
    public string $zipCode;
    public ?string $block;
    public ?string $blockStaircase;
    public ?string $floor;
    public ?string $door;

    public function __construct(string $locationId, string $streetTypeId, string $streetName, string $streetNumber, string $zipCode, ?string $block, ?string $blockStaircase, ?string $floor, ?string $door)
    {
        $this->locationId = $locationId;
        $this->streetTypeId = $streetTypeId;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->zipCode = $zipCode;
        $this->block = $block;
        $this->blockStaircase = $blockStaircase;
        $this->floor = $floor;
        $this->door = $door;
    }
}