<?php

namespace App\Livewire\Ticket;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exceptions\CustomException;
use DB;
use App\Domain\Enums\TicketStatusEnum;
use App\Models\Comment;

class ModifyTicketForm extends Component
{
    use WithPagination;

    public $ticket;

    public $body;
    public $isResolved = true;
    public $resolution_comment_body;
    public $resolution_comment;

    public $from = null;

    public function mount($ticket, $from = null)
    {
        $this->ticket = $ticket;

        $this->resolution_comment = Comment::with(['user'])->whereHas('tickets', function ($query) {
            $query->where('id', $this->ticket->id);
        })->where('isResolutionComment', true)->first();

        if ($this->resolution_comment != null) {
            $this->resolution_comment_body = $this->resolution_comment->body;
        }

        $this->from = $from;
    }


    public function backToInProgress()
    {
        DB::beginTransaction();
        try {

            if ($this->ticket->status->name == TicketStatusEnum::PENDIENTE_CLIENTE->value) {
                $status = Status::firstWhere('name', TicketStatusEnum::EN_CURSO->value);

                $this->ticket->update(['status_id' => $status->id]);

                DB::commit();
                return redirect()->route('admin.dashboard');
            }

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function requestClient()
    {
        $this->validate(['body' => 'required|string'], [
            'body.required' => 'El campo comentario es requerido',
        ]);

        if ($this->ticket->status->name != TicketStatusEnum::PENDIENTE_CLIENTE->value) {
            $this->excuteSaveRequestClient();
        }

    }


    public function save()
    {
        $rule = [];
        $message = [];

        if ($this->isResolved) {
            $rule['resolution_comment_body'] = 'required|string|min:10';
            $message['resolution_comment_body.required'] = 'El campo resolución es requerido';
            $message['resolution_comment_body.min'] = 'El campo resolución debe tener al menos 10 caracteres';
            $this->validate($rule, $message);
        }

        if ($this->body != null) {
            $this->validate(['body' => 'string|min:10'], [
                'body.required' => 'El campo comentario es requerido',
                'body.min' => 'El campo comentario debe tener al menos 10 caracteres',
            ]);

        }


        if ($this->ticket->status->name != TicketStatusEnum::PENDIENTE_CLIENTE->value && ($this->body != null || $this->isResolved)) {
            $this->excuteSave();
        }

    }

    public function excuteSave()
    {
        DB::beginTransaction();
        try {

            if ($this->body != null) {
                $this->ticket->comments()->create([
                    'body' => $this->body,
                    'user_id' => auth()->user()->id
                ]);
            }


            if ($this->isResolved) {
                $status = Status::firstWhere('name', TicketStatusEnum::RESUELTO->value);

                if ($this->resolution_comment != null) {
                    $this->resolution_comment->update([
                        'user_id' => auth()->user()->id,
                        'body' => $this->resolution_comment_body
                    ]);
                } else {
                    $this->ticket->comments()->create([
                        'body' => $this->resolution_comment_body,
                        'user_id' => auth()->user()->id,
                        'isResolutionComment' => true
                    ]);
                }
                $this->ticket->update([
                    'status_id' => $status->id,
                    'isResolved' => $this->isResolved,
                    'resolution_date' => $this->isResolved ? now() : null
                ]);
            }


            DB::commit();
            return redirect()->route('admin.dashboard');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function excuteSaveRequestClient()
    {
        DB::beginTransaction();
        try {
            $status = Status::firstWhere('name', TicketStatusEnum::PENDIENTE_CLIENTE->value);
            $this->ticket->comments()->create([
                'body' => $this->body,
                'user_id' => auth()->user()->id
            ]);

            $this->ticket->update(['status_id' => $status->id, 'isResolved' => false]);
            if ($this->resolution_comment != null) {
                $this->ticket->comments()->detach($this->resolution_comment);
                $this->resolution_comment->delete();
            }
            DB::commit();
            return redirect()->route('admin.dashboard');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }


    public function setIsResolved()
    {
        $this->reset(['resolution_comment']);
    }


    public function render()
    {

        $comments = Comment::with(['user'])->whereHas('tickets', function ($query) {
            $query->where('id', $this->ticket->id);
        })
            ->where('isResolutionComment', false)
            ->orderBy('created_at', 'desc')->paginate(3);
        return view('livewire.ticket.modify-ticket-form', ['comments' => $comments]);
    }
}
