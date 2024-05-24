<?php

namespace App\Domain\Dto\User;

class CreateUserDetailDto
{
    public function __construct(
        public int $userId,
        public string $firstLastName,
        public ?string $secondLastName,
        public string $documentType,
        public string $documentNumber,
        public string $phone,
        public string $clientType,
        public string $addressId,
        public string $userTitle,
        public string $housingType,
        public ?string $responsibleId,
        public ?string $adviserAssignedId,
    ) {
    }
}