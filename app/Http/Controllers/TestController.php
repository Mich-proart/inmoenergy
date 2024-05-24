<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\TestRequest;
use App\Domain\Services\Address\AddressService;
use App\Domain\Services\User\UserService;
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
            $address = $this->addressService->createAddress($request->CreateAddressDto());

            $user = $this->userService->create($request->createUserDto());

            $user->details()->create(['user_id' => $user->id, 'address_id' => $address->id]);
            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }
}
