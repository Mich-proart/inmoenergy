<?php

namespace App\Domain\User\Services;


use App\Domain\User\Dtos\CreateUserDetailDto;
use App\Domain\User\Dtos\CreateUserDto;
use App\Exceptions\CustomException;
use App\Models\IncentiveType;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\ClientType;
use App\Models\DocumentType;
use App\Models\UserTitle;
use Hash;
use DB;
use Illuminate\Contracts\Database\Query\Builder;
use Spatie\Permission\Models\Role;

class UserService
{

    private User $user;
    private $file = null;
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
            'isWorker' => 0,
            'first_last_name' => $dto->firstLastName,
            'second_last_name' => $dto->secondLastName,
            'phone' => $dto->phone,
            'document_number' => $dto->documentNumber,
            'document_type_id' => $dto->documentTypeId,
            'client_type_id' => $dto->clientTypeId,
            'adviser_assigned_id' => $dto->adviserAssignedId,
            'responsible_id' => $dto->responsibleId,
            'user_title_id' => $dto->userTitleId,
            'IBAN' => $dto->IBAN
        ]);

        return $this->user;

    }
    /*
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
            'adviser_assigned_id' => $dto->adviserAssignedId,
            'responsible_id' => $dto->responsibleId,
            'user_title_id' => $dto->userTitleId,
            'IBAN' => $dto->IBAN
        ]);
    }
        */

    public function getClientTypes()
    {
        return ClientType::all();
    }
    public function getIncentiveTypes()
    {
        return IncentiveType::all();
    }
    public function getRoles()
    {
        return Role::all();
    }

    public function getDocumentTypes()
    {
        return DocumentType::all();
    }

    public function getUserTitles()
    {
        return UserTitle::all();
    }

    public function addFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function collesionFile(string $folder, string $name)
    {
        $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

        if ($this->file) {
            $this->user->files()->create([
                'name' => $name,
                'filename' => $newFilename,
                'mime_type' => $this->file->getMimeType(),
                'folder' => $folder
            ]);
            $this->file->storeAs('public/' . $folder, $newFilename);
        }
    }

    public function getUser()
    {

        return $this->user;
    }

    private function UsersQueryBuilder(): Builder
    {
        return DB::table('users')
            ->leftJoin('address', 'address.id', '=', 'users.address_id')
            ->leftJoin('street_type', 'street_type.id', '=', 'address.street_type_id')
            ->leftJoin('housing_type', 'housing_type.id', '=', 'address.housing_type_id')
            ->leftJoin('location', 'location.id', '=', 'address.location_id')
            ->leftJoin('province', 'province.id', '=', 'location.province_id')
            ->select(
                'users.*',
                'users.id as user_id',
                'address.id as address_id',
                'location.name as location',
                'location.id as location_id',
                'province.name as province',
                'province.id as province_id',
                'street_type.name as street_type',
                'housing_type.name as housing_type',
                'address.street_name as street_name',
                'address.street_number as street_number',
                'address.zip_code as zip_code',
                'address.block as block',
                'address.block_staircase as block_staircase',
                'address.floor as floor',
                'address.door as door'
            );
    }

    public function getClientUsers(bool $isCliente)
    {

        $queryBuilder = $this->UsersQueryBuilder();
        if ($isCliente == true) {
            $queryBuilder->where('users.isWorker', '=', 0)->where('users.incentive_type_id', '!=', null);
        }
        if (!$isCliente) {
            $queryBuilder->where('users.isWorker', '=', 1);
        }



        return $queryBuilder->get();

    }

    public function getById(int $id)
    {
        return User::where('id', $id)
            ->with([
                'address',
                'address.streetType',
                'address.housingType',
                'address.location',
                'address.location.province',
                'address.location.province.region',
                'clientType',
                'documentType',
                'title',
                'adviserAssigned',
                'responsible',
                'incentive',
                'roles'
            ])->first();
    }
}