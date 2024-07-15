<?php

namespace App\Domain\Company\Dtos;


class CreateCompanyDto
{
    public function __construct(
        public readonly string $name
    ) {
    }
}