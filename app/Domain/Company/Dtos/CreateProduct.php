<?php

namespace App\Domain\Company\Dtos;

class CreateProductDto
{
    public function __construct(
        public readonly string $name,
        public readonly int $company_id
    ) {
    }
}