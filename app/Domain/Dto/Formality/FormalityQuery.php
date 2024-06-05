<?php

namespace App\Domain\Dto\Formality;

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