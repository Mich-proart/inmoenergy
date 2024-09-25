<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Livewire\Component;

class ResolvedLayoutModal extends Component
{

    public Ticket $ticket;

    public function getInfo($ticketId)
    {
        $this->ticket = Ticket::with(['formality', 'status'])->firstWhere('id', $ticketId);
    }

    public function render()
    {
        return view('livewire.ticket.resolved-layout-modal');
    }
}
