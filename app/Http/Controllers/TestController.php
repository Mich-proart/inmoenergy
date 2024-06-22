<?php

namespace App\Http\Controllers;

use App\Domain\Address\Services\AddressService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Http\Requests\Formality\CreateFormality;
use App\Http\Requests\TestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct(private AddressService $addressService, private UserService $userService)
    {
    }

    public function index(CreateFormality $request)
    {
        return response($request->getCreatUserDetailDto()->clientTypeId, 200);
    }
}
