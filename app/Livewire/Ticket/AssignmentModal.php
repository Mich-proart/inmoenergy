<?php

namespace App\Livewire\Ticket;

use App\Domain\Enums\TicketStatusEnum;
use App\Models\Status;
use App\Models\Ticket;
use Livewire\Component;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use App\Exceptions\CustomException;

class AssignmentModal extends Component
{

    public $user_assigned_id;

    public Ticket $ticket;

    protected $rules = [
        'user_assigned_id' => 'required|exists:users,id',
    ];

    protected $messages = [
        'user_assigned_id.required' => 'Debes seleccionar un usuario',
        'user_assigned_id.exists' => 'Debes seleccionar un usuario existente',
    ];

    public function editTicket($ticketId)
    {
        $this->ticket = Ticket::firstWhere('id', $ticketId);
    }


    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
            $status = Status::firstWhere('name', TicketStatusEnum::ASIGNADO->value);


            $updates = [
                'status_id' => $status->id,
                'user_assigned_id' => $this->user_assigned_id,
                'assignment_date' => now()
            ];

            $this->ticket->update($updates);

            DB::commit();
            return redirect()->route('admin.ticket.assignment');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->where('isActive', 1)->get();
    }

    public function render()
    {
        return view('livewire.ticket.assignment-modal');
    }
}
