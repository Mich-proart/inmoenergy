<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Domain\Ticket\Services\TicketService;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{

    public function __construct(
        private readonly TicketService $ticketService
    )
    {
        $this->middleware('auth');
        $this->middleware('can:ticket.create')->only('create');
        $this->middleware('can:ticket.pending.access')->only('getPending', 'edit');
        $this->middleware('can:ticket.resolved.access')->only('getResolved');
        $this->middleware('can:ticket.resolved.access.worker')->only('getResolvedWorker');
        $this->middleware('can:ticket.assigned.access')->only('getAssigned', 'modify');
        $this->middleware('can:ticket.total.closed.access')->only('getTotalClosed');
        $this->middleware('can:ticket.assignment.access')->only('getAssignment');
        $this->middleware('can:ticket.total.pending.access')->only('getTotalPending', 'modify');
    }

    public function create()
    {
        $program = Program::where('name', 'nuevo ticket')->first();
        return view('admin.ticket.create', ['program' => $program]);
    }

    public function getPending()
    {
        $program = Program::where('name', 'tickets pendientes')->first();
        return view('admin.ticket.pending', ['program' => $program]);
    }

    public function edit(int $id, Request $request)
    {
        $from = $request->query('from');
        $program = Program::where('name', 'tickets pendientes')->first();

        $ticket = $this->ticketService->getById($id);

        if (!$ticket) {
            return view('admin.error.notFound');
        }

        return view('admin.ticket.edit', ['program' => $program, 'ticket' => $ticket, 'from' => $from]);
    }

    public function getAssigned()
    {
        $program = Program::where('name', 'tickets asignados')->first();
        return view('admin.ticket.assigned', ['program' => $program]);
    }

    public function getAssignment()
    {
        $program = Program::where('name', 'asignación de tickets')->first();
        return view('admin.ticket.assignment', ['program' => $program]);
    }

    public function getResolved()
    {
        $program = Program::where('name', 'tickets resueltos')->first();
        return view('admin.ticket.resolved', ['program' => $program]);
    }

    public function getResolvedWorker()
    {
        $program = Program::where('name', 'tickets resueltos')->first();
        return view('admin.ticket.resolvedWorker', ['program' => $program]);
    }

    public function getTotalClosed()
    {
        $program = Program::where('name', 'tickets cerrados totales')->first();
        return view('admin.ticket.totalClosed', ['program' => $program]);
    }

    public function getTotalPending()
    {
        $program = Program::where('name', 'tickets pendientes totales')->first();
        return view('admin.ticket.totalPending', ['program' => $program]);
    }

    public function getView(int $id)
    {
        $ticket = $this->ticketService->getById($id);

        if ($ticket) {
            $program = Program::where('name', 'tickets resueltos')->first();
            return view('admin.ticket.view', ['ticket' => $ticket, 'program' => $program]);
        } else {
            return view('admin.error.notFound');
        }

    }

    public function modify(int $id, Request $request)
    {
        $from = $request->query('from');
        $program = Program::where('name', operator: 'tickets asignados')->first();

        $ticket = $this->ticketService->getById($id);

        if (!$ticket) {
            return view('admin.error.notFound');
        }

        return view('admin.ticket.modify', ['ticket' => $ticket, 'from' => $from, 'program' => $program]);

    }
}
