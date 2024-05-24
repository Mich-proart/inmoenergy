<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\TestRequest;
use App\Services\AddressService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct(private AddressService $addressService, private UserService $userService)
    {
    }

    public function index(TestRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = $this->userService->create($request->createUserDto());
            $address = $this->addressService->createAddress($request->CreateAddressDto());

            $user->details()->create(['user_id' => $user->id, 'address_id' => $address->id]);
            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }
}
