<?php

namespace App\Domain\User\Dtos;

class CreateUserDto
{
    public string $name;
    public string $email;
    public string $password;
    public bool $isWorker;
    public function __construct(
        string $name,
        string $email,
        string $password,
        bool $isWorker,
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
        $this->name = strtolower($name);
        $this->email = $email;
        $this->password = $password;
        $this->isWorker = $isWorker;
    }
}
