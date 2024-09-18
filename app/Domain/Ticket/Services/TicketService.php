<?php

namespace App\Domain\Ticket\Services;
use App\Models\Component;
use App\Models\ComponentOption;
use App\Models\Ticket;

class TicketService
{

    private function getComponent(string $componentName)
    {
        $component = Component::where('alias', $componentName)->first();
        return $component;
    }

    public function getTicketTypes()
    {
        $component = $this->getComponent('ticket_type');
        return ComponentOption::whereBelongsTo($component)->get();
    }

    public function getById(int $id)
    {
        return Ticket::with([
            'issuer',
            'assigned',
            'status',
            'formality',
            'formality.client',
            'formality.service',
            'formality.address',
            'formality.address.streetType',
        ])->firstWhere('id', $id);
    }
}