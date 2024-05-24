<?php

namespace App\Domain\Services\User;

use App\Domain\Dto\User\CreateUserDto;
use App\Exceptions\CustomException;
use App\Models\User;
use Hash;

class UserService
{
    public function __construct()
    {
        //
    }

    public function create(CreateUserDto $dto)
    {

        $found = User::where('email', $dto->email)->first();
        if ($found)
            throw CustomException::badRequestException('User already exists');
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make('test'),
            'isWorker' => 0
        ]);

    }
}