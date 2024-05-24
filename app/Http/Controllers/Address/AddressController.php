<?php

namespace App\Http\Controllers\Address;

use App\Domain\Services\Address\AddressService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(private AddressService $addressService)
    {
    }

    public function getProvinces(int $regionId = null)
    {
        $data = $this->addressService->getProvinces($regionId);
        return response()->json($data, 200);
    }

    public function getLocations(int $provinceId)
    {
        $data = $this->addressService->getLocations($provinceId);
        return response()->json($data, 200);
    }

    public function getStreetTypes()
    {
        $data = $this->addressService->getStreetTypes();
        return response()->json($data, 200);
    }

}
