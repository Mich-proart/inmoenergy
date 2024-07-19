<?php

namespace App\Domain\Formality\Services;

use App\Domain\Formality\Dtos\FormalityQuery;
use App\Models\Component;
use App\Models\ComponentOption;
use App\Models\Formality;
use App\Models\Status;
use DB;
use Illuminate\Contracts\Database\Query\Builder;

class FormalityService
{

    private function formalityQuery(): Builder
    {
        return DB::table('formality')
            ->join('status', 'status.id', '=', 'formality.status_id')
            ->join('component_option as type', 'type.id', '=', 'formality.formality_type_id')
            ->join('component_option as service', 'service.id', '=', 'formality.service_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'formality.user_assigned_id')
            ->join('users as client', 'client.id', '=', 'formality.user_client_id')
            ->join('users as issuer', 'issuer.id', '=', 'formality.user_issuer_id')
            ->join('component_option as document_type', 'document_type.id', '=', 'client.document_type_id')
            ->join('address', 'address.id', '=', 'formality.address_id')
            ->join('component_option as street_type', 'street_type.id', '=', 'address.street_type_id')
            ->join('location', 'location.id', '=', 'address.location_id')
            ->join('province', 'province.id', '=', 'location.province_id')
            ->leftJoin('product', 'product.id', '=', 'formality.product_id')
            ->leftJoin('company', 'company.id', '=', 'product.company_id')
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
                'formality.activation_date',
                'formality.isRenewable',
                'formality.renewal_date',
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
                'document_type.name as document_type',
                'address.*',
                'street_type.name as street_type',
                'location.name as location',
                'province.name as province',
                'company.name as company',
                'product.name as product'
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

    private function getComponent(string $componentName)
    {
        $component = Component::where('alias', $componentName)->first();
        return $component;
    }

    public function getFormalityTypes()
    {
        $component = $this->getComponent('formality_type');
        return ComponentOption::whereBelongsTo($component)->get();
    }

    public function getServices()
    {
        $component = $this->getComponent('service');
        return ComponentOption::whereBelongsTo($component)->get();
    }

    public function getAccessRates()
    {
        $component = $this->getComponent('access_rate');
        return ComponentOption::whereBelongsTo($component)->get();
    }

    public function getFormalityStatus(string $status)
    {
        return Status::where('name', $status)->first();
    }
    public function findStatusById(int $id)
    {
        return Status::where('id', $id)->first();
    }

    public function getById(int $id)
    {
        return Formality::where('id', $id)
            ->with(
                [
                    'client',
                    'client.clientType',
                    'client.documentType',
                    'client.title',
                    'issuer',
                    'assigned',
                    'address',
                    'address.streetType',
                    'address.housingType',
                    'address.location',
                    'address.location.province',
                    'address.location.province.region',
                    'CorrespondenceAddress',
                    'CorrespondenceAddress.streetType',
                    'CorrespondenceAddress.housingType',
                    'CorrespondenceAddress.location',
                    'CorrespondenceAddress.location.province',
                    'CorrespondenceAddress.location.province.region',
                    'type',
                    'status',
                    'service',
                    'accessRate',
                    'product',
                    'product.company',
                ]
            )->first();
    }
}