<?php

namespace App\Domain\Ticket\Dtos;

class CreateTicketDto
{
    public int $issuerId;
    public int $formalityId;
    public int $ticketTypeId;
    public string $title;
    public string $description;
    public function __construct(int $formalityId, int $ticketTypeId, string $title, string $description)
    {
        $this->formalityId = $formalityId;
        $this->ticketTypeId = $ticketTypeId;
        $this->title = strtolower($title);
        $this->description = strtolower($description);
    }

    public function setIssuerId(int $issuerId)
    {
        $this->issuerId = $issuerId;
    }
}