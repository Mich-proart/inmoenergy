<?php

namespace App\Domain\Dto\Address;

class CreateAddressDto
{
    public int $locationId;
    public int $streetTypeId;
    public string $streetName;
    public string $streetNumber;
    public string $zipCode;
    public ?string $block;
    public ?string $blockStaircase;
    public ?string $floor;
    public ?string $door;

    public function __construct(int $locationId, int $streetTypeId, string $streetName, string $streetNumber, string $zipCode, ?string $block, ?string $blockStaircase, ?string $floor, ?string $door)
    {
        $this->locationId = $locationId;
        $this->streetTypeId = $streetTypeId;
        $this->streetName = strtolower($streetName);
        $this->streetNumber = $streetNumber;
        $this->zipCode = $zipCode;
        $this->block = strtolower($block);
        $this->blockStaircase = strtolower($blockStaircase);
        $this->floor = strtolower($floor);
        $this->door = strtolower($door);
    }
}