<?php

namespace App\Livewire\Ticket;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class GetComments extends Component
{

    use WithPagination;

    public $ticket;


    public function mount($ticket)
    {
        $this->ticket = $ticket;
    }


    public function render()
    {

        $comments = Comment::with(['user'])->whereHas('tickets', function ($query) {
            $query->where('id', $this->ticket->id);
        })
            ->where('isResolutionComment', false)
            ->orderBy('created_at', 'desc')->paginate(3);

        $resolution_comment = Comment::with(['user'])->whereHas('tickets', function ($query) {
            $query->where('id', $this->ticket->id);
        })->where('isResolutionComment', true)->first();

        return view('livewire.ticket.get-comments', ['comments' => $comments, 'resolution_comment' => $resolution_comment]);
    }
}
