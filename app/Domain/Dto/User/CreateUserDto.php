<?php

namespace App\Domain\Dto\User;

class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public bool $isWorker
    ) {
    }
}
