<?php

namespace App\Domain\Ticket\Services;
use App\Domain\Enums\TicketStatusEnum;
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
            'type',
            'status',
            'formality',
            'formality.client',
            'formality.service',
            'formality.address',
            'formality.address.streetType',
            'formality.address.location',
            'formality.address.location.province',
        ])->firstWhere('id', $id);
    }

    public function getByFormalityIdNotResolved(int $formalityId)
    {
        return Ticket::with(['status', 'type', 'issuer'])
            ->where('formality_id', $formalityId)
            ->whereHas('status', function ($query) {
                $query->where('name', '!=', TicketStatusEnum::RESUELTO->value);
            })
            ->get();

    }
}