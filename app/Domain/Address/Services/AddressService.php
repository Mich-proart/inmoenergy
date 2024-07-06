<?php

namespace App\Domain\Address\Services;

use App\Domain\Address\Dtos\CreateAddressDto;
use App\Exceptions\CustomException;
use App\Models\Address;
use App\Models\Location;
use App\Models\Province;
use App\Models\Region;
use App\Models\StreetType;
use App\Models\HousingType;

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

    public function getHousingTypes()
    {
        return HousingType::all();
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


        $address = new Address();
        $address->location_id = $location->id;
        $address->street_type_id = $streetType->id;
        $address->street_name = $dto->streetName;
        $address->street_number = $dto->streetNumber;
        $address->zip_code = $dto->zipCode;
        $address->block = $dto->block;
        $address->block_staircase = $dto->blockStaircase;
        $address->floor = $dto->floor;
        $address->door = $dto->door;
        $address->housing_type_id = $dto->housingTypeId;
        $address->save();

        return $address;
    }
}