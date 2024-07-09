<?php

namespace App\Domain\User\Services;


use App\Domain\User\Dtos\CreateUserDetailDto;
use App\Domain\User\Dtos\CreateUserDto;
use App\Exceptions\CustomException;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\ClientType;
use App\Models\DocumentType;
use App\Models\UserTitle;
use Hash;
use DB;
use Illuminate\Contracts\Database\Query\Builder;

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
            ->select('users.*');
    }

    private function getClientUsers()
    {

    }
}