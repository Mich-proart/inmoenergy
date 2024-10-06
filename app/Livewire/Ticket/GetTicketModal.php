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
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class GetTicketModal extends Component
{
    use WithPagination;

    public $formality;

    public $to;
    public $from;
    public bool $checkStatus;

    public $selected_ticket;


    protected $ticketService;

    public $title;
    public $description;
    public $ticketTypeId;

    public Status $defaultStatus;

    public $issuer;

    protected $rules = [
        'title' => 'required|string|min:8',
        'ticketTypeId' => 'required|exists:component_option,id',
        'description' => 'required|string|min:8'
    ];

    protected $messages = [
        'title.required' => 'Valor requerido',
        'title.string' => 'Valor invalido',
        'title.min' => 'Debe ser al menos de 8 caracteres',
        'ticketTypeId.required' => 'Valor requerido',
        'ticketTypeId.exists' => 'Valor invalido',
        'description.required' => 'Valor requerido',
        'description.string' => 'Valor invalido',
        'description.min' => 'Debe ser al menos de 8 caracteres',
    ];

    public function __construct()
    {
        $this->ticketService = App::make(TicketService::class);
        $this->defaultStatus = Status::where('name', TicketStatusEnum::PENDIENTE->value)->first();

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

    #[On('startProcess')]
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

    #[Computed()]
    public function types()
    {
        return $this->ticketService->getTicketTypes();
    }

    public function getDataTicket()
    {
        return [
            'user_issuer_id' => Auth::user()->id,
            'formality_id' => $this->formality->id,
            'ticket_title' => strtolower($this->title),
            'ticket_description' => strtolower($this->description),
            'ticket_type_id' => $this->ticketTypeId,
            'status_id' => $this->defaultStatus->id
        ];
    }

    public function createTicket()
    {
        $this->validate();


        if ($this->formality == null) {

        } else {
            DB::beginTransaction();

            try {

                Ticket::create($this->getDataTicket());

                DB::commit();
                $this->dispatch('notification-created', title: "Ticket creado con exito");

            } catch (\Throwable $th) {

                DB::rollBack();
                throw CustomException::badRequestException($th->getMessage());
            }

        }

    }

    public function resetCreateTicket()
    {
        $this->reset(['title', 'description', 'ticketTypeId']);
        $this->resetValidation(['title', 'description', 'ticketTypeId']);
    }

    public function render()
    {

        $tickets = Ticket::with(['status', 'type', 'issuer'])
            ->where('formality_id', $this->formality->id)
            ->whereHas('status', function ($query) {
                $query->where('name', '!=', TicketStatusEnum::RESUELTO->value);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.ticket.get-ticket-modal', ['tickets' => $tickets]);
    }
}
