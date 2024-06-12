<?php

namespace App\Domain\User\Dtos;

class CreateUserDto
{
    public string $name;
    public string $email;
    public string $password;
    public bool $isWorker;
    public function __construct(string $name, string $email, string $password, bool $isWorker)
    {
        $this->name = strtolower($name);
        $this->email = $email;
        $this->password = $password;
        $this->isWorker = $isWorker;
    }
}
