<?php

namespace App\Domain\Address\Services;

use App\Domain\Address\Dtos\CreateAddressDto;
use App\Exceptions\CustomException;
use App\Models\Address;
use App\Models\Location;
use App\Models\Province;
use App\Models\Region;
use App\Models\StreetType;

class AddressService
{

    public function getRegions()
    {
        return Region::all();
    }
    public function getProvinces(int $regionId = null)
    {
        if (!isset($regionId))
            return Province::with('region')->get();

        return Province::where('region_id', $regionId)->with('region')->get();
    }

    public function getLocations(int $provinceId)
    {
        if (!isset($provinceId))
            throw CustomException::badRequestException('province id ' . $provinceId . ' required');

        return Location::where('province_id', $provinceId)->get();
    }

    public function getStreetTypes()
    {
        return StreetType::all();
    }

    public function createAddress(CreateAddressDto $dto)
    {
        $location = Location::find($dto->locationId);

        if (!isset($location))
            throw CustomException::badRequestException('location id ' . $dto->locationId . ' required');

        $streetType = StreetType::find($dto->streetTypeId);
        if (!isset($streetType))
            throw CustomException::badRequestException('street type id ' . $dto->streetTypeId . ' required');


        return Address::firstOrCreate([
            'location_id' => $location->id,
            'street_type_id' => $streetType->id,
            'street_name' => $dto->streetName,
            'street_number' => $dto->streetNumber,
            'zip_code' => $dto->zipCode,
            'block' => $dto->block,
            'block_staircase' => $dto->blockStaircase,
            'floor' => $dto->floor,
            'door' => $dto->door
        ]);
    }
}