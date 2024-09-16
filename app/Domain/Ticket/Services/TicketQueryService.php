<?php
namespace App\Domain\Ticket\Services;
use App\Domain\Enums\TicketStatusEnum;
use DB;

class TicketQueryService
{
    public function ticketQuery()
    {
        return DB::table('ticket')
            ->join('status', 'status.id', '=', 'ticket.status_id')
            ->join('formality', 'formality.id', '=', 'ticket.formality_id')
            ->join('client as client', 'client.id', '=', 'formality.client_id')
            ->join('users as issuer', 'issuer.id', '=', 'ticket.user_issuer_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'ticket.user_assigned_id')
            ->join('component_option as service', 'service.id', '=', 'formality.service_id')
            ->join('address', 'address.id', '=', 'formality.address_id')
            ->join('component_option as street_type', 'street_type.id', '=', 'address.street_type_id')
            ->join('component_option as ticket_type', 'ticket_type.id', '=', 'ticket.ticket_type_id')
            ->select(
                'status.name as status',
                'ticket.id as ticket_id',
                'service.name as service',
                'client.name as name',
                'client.first_last_name as firstLastName',
                'client.second_last_name as secondLastName',
                'address.*',
                'street_type.name as street_type',
                'ticket.*',
                'ticket_type.name as type',
                'userAssigned.name as assigned_name',
                'userAssigned.first_last_name as assigned_firstLastName',
                'userAssigned.second_last_name as assigned_secondLastName',
                'issuer.name as issuer_name',
                'issuer.first_last_name as issuer_firstLastName',
                'issuer.second_last_name as issuer_secondLastName',
            );
    }

    public function getPending(int $issuerId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereNotIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }
    public function getResolved(int $issuerId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }

    public function getAssigned(int $assignedId)
    {

        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
        $queryBuilder->WhereNotIn('status.name', [TicketStatusEnum::RESUELTO->value]);

        return $queryBuilder->get();
    }

    public function getTotalPending(int $issuerId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->WhereNotIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }
}