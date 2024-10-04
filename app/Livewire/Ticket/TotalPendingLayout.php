<?php

namespace App\Livewire\Ticket;

use Livewire\Component;
use App\Domain\Enums\TicketStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Status;
use App\Domain\Ticket\Services\TicketService;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\On;

class TotalPendingLayout extends Component
{

    protected $ticketService;
    public $selected_ticket;

    public function __construct()
    {
        $this->ticketService = App::make(TicketService::class);

    }

    #[On('process')]
    public function process($id)
    {

        $this->selected_ticket = $this->ticketService->getById($id);
        if ($this->selected_ticket->status->name == TicketStatusEnum::ASIGNADO->value) {
            $this->dispatch('approve');
        } else {
            return redirect()->route('admin.ticket.modify', $id);
        }

    }

    #[On('startProcess')]
    public function startProcess()
    {

        DB::beginTransaction();
        try {
            $status = Status::firstWhere('name', TicketStatusEnum::EN_CURSO->value);

            if ($this->selected_ticket) {
                $this->selected_ticket->update(['status_id' => $status->id]);
                DB::commit();
                return redirect()->route('admin.ticket.modify', $this->selected_ticket->id);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.ticket.total-pending-layout');
    }
}
