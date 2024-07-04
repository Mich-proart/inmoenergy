<?php

namespace App\Domain\Formality\Services;


use App\Domain\Formality\Dtos\FormalityQuery;
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
            ->join('address', 'address.id', '=', 'formality.address_id')
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

    public function findById(int $id)
    {
        return DB::table('formality')
            ->join('formality_status as status', 'status.id', '=', 'formality.formality_status_id')
            ->join('formality_type as type', 'type.id', '=', 'formality.formality_type_id')
            ->join('service', 'service.id', '=', 'formality.service_id')
            ->leftJoin('users as userAssigned', 'userAssigned.id', '=', 'formality.user_assigned_id')
            ->join('users as client', 'client.id', '=', 'formality.user_client_id')
            ->leftJoin('users as issuer', 'issuer.id', '=', 'formality.user_issuer_id')
            ->join('user_detail as detail', 'detail.user_id', '=', 'client.id')
            ->join('document_type', 'document_type.id', '=', 'detail.document_type_id')
            ->join('address', 'address.id', '=', 'formality.address_id')
            ->leftJoin('address as correspondence_address', 'correspondence_address.id', '=', 'formality.correspondence_address_id')
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
                'formality.formality_type_id as formalityTypeId',
                'formality.service_id as serviceId',
                'formality.isSameCorrespondenceAddress as isSameCorrespondenceAddress',
                'formality.issuer_observation as issuer_observation',
                'issuer.name as issuer',
                'status.name as status',
                'service.name as service',
                'type.name as type',
                'userAssigned.name as assigned',
                'client.name as name',
                'client.email as email',
                'detail.first_last_name as firstLastName',
                'detail.second_last_name as secondLastName',
                'detail.document_number as documentNumber',
                'detail.phone as phone',
                'detail.IBAN as IBAN',
                'detail.client_type_id as clientTypeId',
                'detail.document_type_id as documentTypeId',
                'detail.user_title_id as userTitleId',
                'document_type.name as document_type',
                'document_type.id as documentTypeId',
                'address.id as addressId',
                'address.location_id as locationId',
                'address.street_type_id as streetTypeId',
                'address.housing_type_id as housingTypeId',
                'address.street_name as streetName',
                'address.street_number as streetNumber',
                'address.zip_code as zipCode',
                'address.block as block',
                'address.block_staircase as blockstaircase',
                'address.floor as floor',
                'address.door as door',
                'correspondence_address.id as client_addressId',
                'correspondence_address.location_id as client_locationId',
                'correspondence_address.street_type_id as client_streetTypeId',
                'correspondence_address.housing_type_id as client_housingTypeId',
                'correspondence_address.street_name as client_streetName',
                'correspondence_address.street_number as client_streetNumber',
                'correspondence_address.zip_code as client_zipCode',
                'correspondence_address.block as client_block',
                'correspondence_address.block_staircase as client_blockstaircase',
                'correspondence_address.floor as client_floor',
                'correspondence_address.door as client_door',
                'street_type.name as streetType',
                'location.name as location',
                'province.id as provinceId',
                'province.name as province'
            )->where('formality.id', $id)->first();
    }
}