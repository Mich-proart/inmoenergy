<?php

namespace App\Domain\Formality\Services;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Dtos\FormalityQuery;
use DB;
use Illuminate\Contracts\Database\Query\Builder;

class FormalityQueryService
{

    private function formalityQuery(): Builder
    {
        return DB::table('formality')
            ->join('status', 'status.id', '=', 'formality.status_id')
            ->join('component_option as type', 'type.id', '=', 'formality.formality_type_id')
            ->join('component_option as service', 'service.id', '=', 'formality.service_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'formality.user_assigned_id')
            ->join('client as client', 'client.id', '=', 'formality.client_id')
            ->join('users as issuer', 'issuer.id', '=', 'formality.user_issuer_id')
            ->join('address', 'address.id', '=', 'formality.address_id')
            ->join('component_option as street_type', 'street_type.id', '=', 'address.street_type_id')
            ->join('location', 'location.id', '=', 'address.location_id')
            ->join('province', 'province.id', '=', 'location.province_id')
            ->leftJoin('product', 'product.id', '=', 'formality.product_id')
            ->leftJoin('company', 'company.id', '=', 'product.company_id')
            ->leftJoin('users as responsible', 'responsible.id', '=', 'issuer.responsible_id')
            ->leftJoin('office', 'office.id', '=', 'issuer.office_id')
            ->leftJoin('business_group', 'business_group.id', '=', 'office.business_group_id')
            ->select(
                'formality.id as formality_id',
                'formality.created_at',
                'formality.activation_date',
                'formality.issuer_observation',
                'formality.assigned_observation',
                'formality.isCritical',
                'formality.observation',
                'formality.completion_date',
                'formality.CUPS',
                'formality.annual_consumption',
                'formality.activation_date',
                'formality.isRenewable',
                'formality.renewal_date',
                'formality.assignment_date',
                'issuer.name as issuer_name',
                'status.name as status',
                'service.name as service',
                'type.name as type',
                'userAssigned.name as assigned_name',
                'client.name as name',
                'client.first_last_name as firstLastName',
                'client.second_last_name as secondLastName',
                'issuer.first_last_name as issuer_firstLastName',
                'issuer.second_last_name as issuer_secondLastName',
                'userAssigned.first_last_name as assigned_firstLastName',
                'userAssigned.second_last_name as assigned_secondLastName',
                'client.document_number as documentNumber',
                'address.*',
                'street_type.name as street_type',
                'location.name as location',
                'province.name as province',
                'company.name as company',
                'product.name as product',
                'responsible.name as responsible_name',
                'responsible.first_last_name as responsible_firstLastName',
                'responsible.second_last_name as responsible_secondLastName',
                'office.name as office',
                'business_group.name as business_group'
            );

    }

    public function getActicationDateNull(int $assignedId)
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
        $queryBuilder->whereNull('formality.activation_date');
        return $queryBuilder->get();
    }
    public function getAssignedNull()
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->whereNull('userAssigned.id');
        return $queryBuilder->get();
    }


    public function totalPending()
    {

        $queryBuilder = $this->formalityQuery();

        $queryBuilder->WhereIn('status.name', [FormalityStatusEnum::FINALIZADO->value]);

        $queryBuilder->whereNull('formality.activation_date');

        return $queryBuilder->get();
    }

    public function getDistintStatus($array)
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->WhereNotIn('status.name', $array);
        return $queryBuilder->get();
    }

    private $mainStatusFilter = [
        FormalityStatusEnum::TRAMITADO->value,
        FormalityStatusEnum::EN_VIGOR->value,
        FormalityStatusEnum::BAJA->value,
        FormalityStatusEnum::FINALIZADO->value
    ];

    public function getInProgress(int $issuerId)
    {

        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereNotIn('status.name', $this->mainStatusFilter);

        return $queryBuilder->get();
    }
    public function getClosed(int $issuerId)
    {

        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('issuer.id', $issuerId);
        $queryBuilder->WhereIn('status.name', $this->mainStatusFilter);

        return $queryBuilder->get();
    }
    public function getAssigned(int $assignedId)
    {

        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
        $queryBuilder->WhereNotIn('status.name', $this->mainStatusFilter);

        return $queryBuilder->get();
    }
    public function getCompleted(int $assignedId)
    {

        $queryBuilder = $this->formalityQuery();
        $queryBuilder->where('userAssigned.id', $assignedId);
        $queryBuilder->WhereIn('status.name', $this->mainStatusFilter);

        return $queryBuilder->get();
    }

    public function getTotalInProgress()
    {
        $queryBuilder = $this->formalityQuery();
        $queryBuilder->WhereNotIn('status.name', $this->mainStatusFilter);
        return $queryBuilder->get();
    }
}