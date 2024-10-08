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
    private function getComponent(string $componentName)
    {
        $component = Component::where('alias', $componentName)->first();
        return $component;
    }

    public function getFormalityTypes()
    {
        $component = $this->getComponent('formality_type');
        return ComponentOption::whereBelongsTo($component)->where('is_available', true)->get();
    }

    public function getServices()
    {
        $component = $this->getComponent('service');
        return ComponentOption::whereBelongsTo($component)->where('is_available', true)->get();
    }
    public function getReasonCancellation()
    {
        $component = $this->getComponent('reason_cancellation');
        return ComponentOption::whereBelongsTo($component)->where('is_available', true)->get();
    }

    public function getServiceByName(string|null $name = null)
    {
        if ($name) {
            $component = $this->getComponent('service');
            return ComponentOption::whereBelongsTo($component)->where('name', $name)->with('children')->first();
        }
    }

    public function getAccessRates(string|null $name = null)
    {
        if ($name) {
            $component = $this->getComponent('service');
            return ComponentOption::whereBelongsTo($component)
                ->where('name', $name)
                ->with('children')
                ->first()->children;
        }

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
                    'client.country',
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
                    'previousCompany',
                    'reasonCancellation'
                ]
            )->first();
    }

    public function getFileById(int $id)
    {
        return Formality::where('id', $id)->with(
            'files',
            'files.config',
            'client',
            'client.files',
            'client.files.config'
        )->first();
    }

    public function getAllByIssuerId(int $issuerId = null)
    {
        $query = Formality::with(
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
                'previousCompany'
            ]
        );

        if (!$issuerId) {
            return $query->get();
        } else {
            return $query->whereHas('client', function ($query) use ($issuerId) {
                $query->where('id', $issuerId);
            });
        }

    }
    public function getQueryWithAll()
    {
        return Formality::with(
            [
                'client',
                'client.clientType',
                'client.documentType',
                'client.title',
                'client.country',
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
                'previousCompany'
            ]
        );

    }
}