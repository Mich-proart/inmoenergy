<?php

namespace App\Livewire\Ticket;

use App\Domain\Enums\TicketStatusEnum;
use App\Models\Comment;
use App\Models\Status;
use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exceptions\CustomException;
use DB;

class EditTicketForm extends Component
{
    use WithPagination;

    public $ticket;

    public $body;

    public function mount($ticket)
    {
        $this->ticket = $ticket;
    }

    public function save()
    {

        $this->validate(['body' => 'required|string'], [
            'body.required' => 'El campo comentario es requerido',
        ]);

        if ($this->ticket->status->name == TicketStatusEnum::PENDIENTE_CLIENTE->value) {
            $this->excuteSave();
        } else {
        }

    }

    public function excuteSave()
    {
        DB::beginTransaction();
        try {
            $status = Status::firstWhere('name', TicketStatusEnum::PENDIENTE_VALIDACION->value);

            $this->ticket->comments()->create([
                'body' => $this->body,
                'user_id' => auth()->user()->id
            ]);

            $this->ticket->update(['status_id' => $status->id]);


            DB::commit();

            return redirect()->route('admin.dashboard');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function render()
    {

        $comments = Comment::with(['user'])->whereHas('tickets', function ($query) {
            $query->where('id', $this->ticket->id);
        })->orderBy('created_at', 'desc')->paginate(3);
        return view('livewire.ticket.edit-ticket-form', ['comments' => $comments]);
    }
}
