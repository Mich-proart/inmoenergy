<?php

namespace App\Domain\Ticket\Services;
use App\Models\Component;
use App\Models\ComponentOption;

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
}