<?php

namespace App\Services;

use App\Dto\Address\CreateAddressDto;
use App\Exceptions\CustomException;
use App\Models\Location;
use App\Models\Province;
use App\Models\Region;

class AddressService
{

    public function getRegions()
    {
        return Region::all();
    }
    public function getProvinces(int $regionId = null)
    {
        if (!isset($regionId))
            return Province::all();

        return Province::where('region_id', $regionId)->get();
    }

    public function getLocations(int $provinceId)
    {
        if (!isset($provinceId))
            throw CustomException::badRequestException('province id ' . $provinceId . ' required');

        return Location::where('province_id', $provinceId)->get();
    }

    public function createAddress(CreateAddressDto $dto)
    {

    }
}