<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Domain\Ticket\Services\TicketQueryService;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketApiController extends Controller
{
    public function __construct(private readonly TicketQueryService $ticketQueryService)
    {
        $this->middleware('auth');
    }

    public function getPending()
    {
        $userId = auth()->user()->id;
        $ticket = $this->ticketQueryService->getPending($userId);

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->toJson(true);
    }
    public function getResolved()
    {
        $userId = auth()->user()->id;
        $ticket = $this->ticketQueryService->getResolved($userId);

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->toJson(true);
    }
    public function getResolvedWorker()
    {
        $userId = auth()->user()->id;
        $ticket = $this->ticketQueryService->getResolvedWorker($userId);

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('issuer', function ($ticket) {
                return $ticket->issuer_name . ' ' . $ticket->issuer_firstLastName . ' ' . $ticket->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->toJson(true);
    }
    public function getAssigned()
    {
        $userId = auth()->user()->id;
        $ticket = $this->ticketQueryService->getAssigned($userId);

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->addColumn('issuer', function ($ticket) {
                return $ticket->issuer_name . ' ' . $ticket->issuer_firstLastName . ' ' . $ticket->issuer_secondLastName;
            })
            ->toJson(true);
    }
    public function getTotalPending()
    {
        $ticket = $this->ticketQueryService->getTotalPending();

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->addColumn('issuer', function ($ticket) {
                return $ticket->issuer_name . ' ' . $ticket->issuer_firstLastName . ' ' . $ticket->issuer_secondLastName;
            })
            ->addColumn('issuer_formality', function ($ticket) {
                return $ticket->issuer_formality_name . ' ' . $ticket->issuer_formality_firstLastName . ' ' . $ticket->issuer_formality_secondLastName;
            })
            ->addColumn('assigned', function ($ticket) {
                return $ticket->assigned_name . ' ' . $ticket->assigned_firstLastName . ' ' . $ticket->assigned_secondLastName;
            })
            ->toJson(true);
    }
    public function getAssignment()
    {
        $ticket = $this->ticketQueryService->getAssignment();

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->addColumn('issuer', function ($ticket) {
                return $ticket->issuer_name . ' ' . $ticket->issuer_firstLastName . ' ' . $ticket->issuer_secondLastName;
            })
            ->addColumn('issuer_formality', function ($ticket) {
                return $ticket->issuer_formality_name . ' ' . $ticket->issuer_formality_firstLastName . ' ' . $ticket->issuer_formality_secondLastName;
            })
            ->addColumn('assigned', function ($ticket) {
                return $ticket->assigned_name . ' ' . $ticket->assigned_firstLastName . ' ' . $ticket->assigned_secondLastName;
            })
            ->toJson(true);
    }

    public function getTotalClosed()
    {
        $ticket = $this->ticketQueryService->getTotalClosed();

        return DataTables::of($ticket)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($ticket) {
                return $ticket->ticket_id;
            })
            ->addColumn('fullName', function ($ticket) {
                return $ticket->name . ' ' . $ticket->firstLastName . ' ' . $ticket->secondLastName;
            })
            ->addColumn('fullAddress', function ($ticket) {
                return $ticket->street_type . ' ' . $ticket->street_name . ' ' . $ticket->street_number . ' ' . $ticket->block . ' ' . $ticket->block_staircase . ' ' . $ticket->floor . ' ' . $ticket->door;
            })
            ->addColumn('issuer', function ($ticket) {
                return $ticket->issuer_name . ' ' . $ticket->issuer_firstLastName . ' ' . $ticket->issuer_secondLastName;
            })
            ->toJson(true);
    }

    public function getFormalityTicket(Request $request)
    {

        $status = $request->input('status');
        $id = $request->input('id');

        $query = Ticket::whereHas('formality', function ($query) use ($id) {
            $query->where('formality_id', $id);
        });

        if (isset($status)) {
            $query->whereHas('status', function ($query) use ($status) {
                $query->whereIn('name', $status);
            });
        }


        $tickets = $query->get();

        return response()->json($tickets, 200);

    }
}
