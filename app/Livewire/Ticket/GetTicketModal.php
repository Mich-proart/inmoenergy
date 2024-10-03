<?php

namespace App\Livewire\Ticket;

use App\Domain\Enums\TicketStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Status;
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

    public $to;
    public $from;
    public bool $checkStatus;

    public $selected_ticket;


    protected $ticketService;

    public function __construct()
    {
        $this->ticketService = App::make(TicketService::class);

    }

    public function mount($formality, $to, $from, $checkStatus = false)
    {
        $this->formality = $formality;
        $this->to = $to;
        $this->from = $from;
        $this->checkStatus = $checkStatus;
    }

    public function process($id)
    {

        $this->selected_ticket = $this->ticketService->getById($id);
        if (!$this->checkStatus) {
            return redirect()->route($this->to, $id);
        } else {
            if ($this->selected_ticket->status->name == TicketStatusEnum::ASIGNADO->value) {
                $this->dispatch('approve');
            } else {
                return redirect()->route($this->to, $id);
            }
        }
    }

    public function startProcess()
    {

        DB::beginTransaction();
        try {
            $status = Status::firstWhere('name', TicketStatusEnum::EN_CURSO->value);

            if ($this->selected_ticket) {
                $this->selected_ticket->update(['status_id' => $status->id]);
                DB::commit();
                return redirect()->route($this->to, $this->selected_ticket->id);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
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
