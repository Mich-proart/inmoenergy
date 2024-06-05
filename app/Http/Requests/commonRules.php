<?php

namespace App\Http\Requests;

use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Enums\HousingTypeEnum;
use App\Domain\Enums\UserTitleEnum;
use Illuminate\Validation\Rule;

trait commonRules
{
    protected function clientRules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ];
    }

    protected function userDetailRules()
    {
        return [
            'firstLastName' => 'required|string',
            'secondLastName' => 'sometimes|nullable|string',
            'documentTypeId' => 'required|integer|exists:document_type,id',
            'documentNumber' => 'required|string',
            'phone' => 'required|string',
            'clientTypeId' => 'required|integer|exists:client_type,id',
            'userTitleId' => 'required|integer|exists:user_title,id',
            'housingTypeId' => 'required|integer|exists:housing_type,id',
            'IBAN' => 'required|string',
        ];
    }

    protected function addressRules()
    {
        return [
            'locationId' => 'required|integer|exists:location,id',
            'streetTypeId' => 'required|integer|exists:street_type,id',
            'streetName' => 'required|string',
            'streetNumber' => 'required|string',
            'zipCode' => 'required|string',
            'block' => 'sometimes|nullable|string',
            'blockstaircase' => 'required|string',
            'floor' => 'sometimes|nullable|string',
            'door' => 'sometimes|nullable|string',
        ];
    }
}