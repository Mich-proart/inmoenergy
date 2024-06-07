<?php

namespace App\Domain\Services\Formality;


use App\Domain\Dto\Formality\FormalityQuery;
use DB;
use Illuminate\Contracts\Database\Query\Builder;
use App\Models\FormalityType;
use App\Models\Service;

class FormalityService
{

    private function formalityQuery(): Builder
    {
        return DB::table('formality')
            ->join('formality_status as status', 'status.id', '=', 'formality.formality_status_id')
            ->join('formality_type as type', 'type.id', '=', 'formality.formality_type_id')
            ->join('service', 'service.id', '=', 'formality.service_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'formality.user_assigned_id')
            ->join('users as client', 'client.id', '=', 'formality.user_client_id')
            ->join('users as issuer', 'issuer.id', '=', 'formality.user_issuer_id')
            ->join('user_detail as detail', 'detail.user_id', '=', 'client.id')
            ->join('document_type', 'document_type.id', '=', 'detail.document_type_id')
            ->join('address', 'address.id', '=', 'detail.address_id')
            ->join('street_type', 'street_type.id', '=', 'address.street_type_id')
            ->join('location', 'location.id', '=', 'address.location_id')
            ->join('province', 'province.id', '=', 'location.province_id')
            ->select(
                'formality.id as formality_id',
                'formality.created_at',
                'formality.activation_date',
                'formality.issuer_observation',
                'formality.isCritical',
                'formality.observation',
                'formality.completion_date',
                'formality.CUPS',
                'formality.annual_consumption',
                'formality.completion_date',
                'formality.activation_date',
                'formality.isRenewable',
                'issuer.name as issuer',
                'status.name as status',
                'service.name as service',
                'type.name as type',
                'userAssigned.name as assigned',
                'client.name as name',
                'detail.first_last_name as firstLastName',
                'detail.second_last_name as secondLastName',
                'detail.document_number as documentNumber',
                'document_type.name as document_type',
                'address.*',
                'street_type.name as street_type',
                'location.name as location',
                'province.name as province'
            );

    }

    public function findByDistintStatus(FormalityQuery $formalityQuery)
    {
        $queryBuilder = $this->formalityQuery();

        if ($formalityQuery->statusArray && is_array($formalityQuery->statusArray) && count($formalityQuery->statusArray) > 0) {
            $queryBuilder->WhereNotIn('status.name', $formalityQuery->statusArray);
        }

        if ($formalityQuery->issuerId) {
            $queryBuilder->where('issuer.id', $formalityQuery->issuerId);
        }

        if ($formalityQuery->assignedId) {
            $queryBuilder->where('userAssigned.id', $formalityQuery->assignedId);
        }

        if ($formalityQuery->activationDateNull || $formalityQuery->activationDateNull === true) {
            $queryBuilder->whereNull('formality.activation_date');
        }

        return $queryBuilder->get();
    }

    public function findByStatus(FormalityQuery $formalityQuery)
    {
        $queryBuilder = $this->formalityQuery();

        if ($formalityQuery->statusArray && is_array($formalityQuery->statusArray) && count($formalityQuery->statusArray) > 0) {
            $queryBuilder->WhereIn('status.name', $formalityQuery->statusArray);
        }

        if ($formalityQuery->issuerId) {
            $queryBuilder->where('issuer.id', $formalityQuery->issuerId);
        }

        if ($formalityQuery->assignedId) {
            $queryBuilder->where('userAssigned.id', $formalityQuery->assignedId);
        }

        if ($formalityQuery->activationDateNull || $formalityQuery->activationDateNull === true) {
            $queryBuilder->whereNull('formality.activation_date');
        }

        return $queryBuilder->get();
    }

    public function getFormalityTypes()
    {
        return FormalityType::all();
    }

    public function getServices()
    {
        return Service::all();
    }
}