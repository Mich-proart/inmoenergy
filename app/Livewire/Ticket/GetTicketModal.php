<?php

namespace App\Livewire\Ticket;

use App\Domain\Enums\TicketStatusEnum;
use App\Models\Ticket;
use Livewire\Component;
use App\Domain\Ticket\Services\TicketService;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\WithPagination;

class GetTicketModal extends Component
{
    use WithPagination;

    public $formality;


    protected $ticketService;

    public function __construct()
    {
        $this->ticketService = App::make(TicketService::class);

    }

    public function mount($formality)
    {
        $this->formality = $formality;
    }

    public function render()
    {

        $tickets = Ticket::with(['status', 'type', 'issuer'])
            ->where('formality_id', $this->formality->id)
            ->whereHas('status', function ($query) {
                $query->where('name', '!=', TicketStatusEnum::RESUELTO->value);
            })
            ->paginate(10);
        return view('livewire.ticket.get-ticket-modal', ['tickets' => $tickets]);
    }
}
