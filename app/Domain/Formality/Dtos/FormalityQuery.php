<?php

namespace App\Domain\Formality\Dtos;

class FormalityQuery
{

    public function __construct(
        public readonly ?int $issuerId,
        public readonly ?int $assignedId,
        public readonly ?bool $activationDateNull,
        public readonly ?array $statusArray,
    ) {
    }
}