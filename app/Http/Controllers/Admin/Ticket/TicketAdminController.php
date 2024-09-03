<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
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
}
