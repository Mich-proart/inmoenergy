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
    public function ticketQueryTotalPending()
    {
        return DB::table('ticket')
            ->join('status', 'status.id', '=', 'ticket.status_id')
            ->join('formality', 'formality.id', '=', 'ticket.formality_id')
            ->join('users as issuer_formality', 'issuer_formality.id', '=', 'formality.user_issuer_id')
            ->leftJoin('office', 'office.id', '=', 'issuer_formality.office_id')
            ->leftJoin('business_group', 'business_group.id', '=', 'office.business_group_id')
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
                'issuer_formality.name as issuer_formality_name',
                'issuer_formality.first_last_name as issuer_formality_firstLastName',
                'issuer_formality.second_last_name as issuer_formality_secondLastName',
                'office.name as office',
                'business_group.name as business_group',
                'issuer_formality.responsible_name as issuer_formality_responsible_name'
            );
    }

    public function getPending(int $issuerId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereIn('status.name', [TicketStatusEnum::PENDIENTE_CLIENTE->value]);
        $queryBuilder->where('formality.user_issuer_id', $issuerId);
        return $queryBuilder->get();
    }
    public function getResolved(int $issuerId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }

    public function getResolvedWorker(int $assignedId)
    {
        $queryBuilder = $this->ticketQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
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

    public function getTotalPending()
    {
        $queryBuilder = $this->ticketQueryTotalPending();
        $queryBuilder->WhereNotIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }
    public function getAssignment()
    {
        $queryBuilder = $this->ticketQueryTotalPending();
        $queryBuilder->whereNull('userAssigned.id');
        return $queryBuilder->get();
    }

    public function getTotalClosed()
    {
        $queryBuilder = $this->ticketQueryTotalPending();
        $queryBuilder->WhereIn('status.name', [TicketStatusEnum::RESUELTO->value]);
        return $queryBuilder->get();
    }
}