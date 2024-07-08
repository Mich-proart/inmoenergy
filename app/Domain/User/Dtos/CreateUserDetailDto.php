<?php

namespace App\Domain\User\Dtos;

class CreateUserDetailDto
{

    public int $userId;

    public function __construct(
        public string $firstLastName,
        public string $secondLastName,
        public int $documentTypeId,
        public string $documentNumber,
        public string $phone,
        public int $clientTypeId,
        public int $userTitleId,
        public string $IBAN,
        public ?int $responsibleId,
        public ?int $adviserAssignedId,
    ) {
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

}