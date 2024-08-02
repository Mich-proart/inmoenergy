<?php

namespace App\Domain\Formality\Services;

use App\Domain\Formality\Dtos\FormalityQuery;
use DB;
use Illuminate\Contracts\Database\Query\Builder;


class CountQueryService
{
    private function formalityQuery(): Builder
    {
        return DB::table('formality')
            ->join('status', 'status.id', '=', 'formality.status_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'formality.user_assigned_id')
            ->join('users as client', 'client.id', '=', 'formality.user_client_id')
            ->join('users as issuer', 'issuer.id', '=', 'formality.user_issuer_id');

    }

    public function getActicationDateNull(int $assignedId): int
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
        $queryBuilder->whereNull('formality.activation_date');
        return $queryBuilder->count();
    }
    public function getAssignedNull(): int
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->whereNull('userAssigned.id');
        return $queryBuilder->count();
    }

    public function findByDistintStatus(FormalityQuery $formalityQuery): int
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

        return $queryBuilder->count();
    }

    public function findByStatus(FormalityQuery $formalityQuery): int
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

        return $queryBuilder->count();
    }
}