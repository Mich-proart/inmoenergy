<?php

namespace App\Domain\Services\User;

use App\Domain\Dto\User\CreateUserDetailDto;
use App\Domain\Dto\User\CreateUserDto;
use App\Exceptions\CustomException;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\ClientType;
use App\Models\DocumentType;
use App\Models\HousingType;
use App\Models\UserTitle;
use Hash;

class UserService
{

    private User $user;
    public function __construct()
    {
        //
    }

    public function create(CreateUserDto $dto)
    {

        $found = User::where('email', $dto->email)->first();
        if ($found)
            throw CustomException::badRequestException('User already exists');
        $this->user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make('test'),
            'isWorker' => 0
        ]);

        return $this->user;

    }

    public function setUserDetails(CreateUserDetailDto $dto)
    {
        $details = UserDetail::create([
            'user_id' => $this->user->id,
            'first_last_name' => $dto->firstLastName,
            'second_last_name' => $dto->secondLastName,
            'phone' => $dto->phone,
            'document_number' => $dto->documentNumber,
            'document_type_id' => $dto->documentTypeId,
            'client_type_id' => $dto->clientTypeId,
            'address_id' => $dto->addressId,
            'adviser_assigned_id' => $dto->adviserAssignedId,
            'responsible_id' => $dto->responsibleId,
            'user_title_id' => $dto->userTitleId,
            'housing_type_id' => $dto->housingTypeId,
            'IBAN' => $dto->IBAN
        ]);
    }

    public function getClientTypes()
    {
        return ClientType::all();
    }

    public function getDocumentTypes()
    {
        return DocumentType::all();
    }

    public function getUserTitles()
    {
        return UserTitle::all();
    }

    public function getHousingTypes()
    {
        return HousingType::all();
    }
}