<?php

namespace App\Domain\Formality\Services;
use Illuminate\Support\Collection;

class FormatFormalityService
{

    public static function toArrayAll(Collection $set)
    {
        $test = $set->map(function ($item) {
            return [
                'código trámite' => $item->id,
                'cliente emisor trámite' => isset($item->issuer) ? $item->issuer->name . ' ' . $item->issuer->first_last_name . ' ' . $item->issuer->second_last_name : '',
                'fecha y hora entrada trámite' => isset($item->created_at) ? $item->getCreateAtFormatted() : '',
                'usuario asignado' => isset($item->assigned) ? $item->assigned->name . ' ' . $item->assigned->first_last_name . ' ' . $item->assigned->second_last_name : '',
                'fecha y hora asignación' => isset($item->assignment_date) ? $item->assignment_date : '',
                'tipo trámite' => isset($item->type) ? $item->type->name : '',
                'suministro' => isset($item->service) ? $item->service->name : '',
                'tipo cliente' => isset($item->client->clientType) ? $item->client->clientType->name : '',
                'cliente final' => isset($item->client) ? $item->client->name . ' ' . $item->client->first_last_name . ' ' . $item->client->second_last_name : '',
                'email cliente final' => isset($item->client) ? $item->client->email : '',
                'tratamiento cliente final' => isset($item->client->title) ? $item->client->title->name : '',
                'tipo de documento cliente final' => isset($item->client->documentType) ? $item->client->documentType->name : '',
                'numero documento cliente final' => isset($item->client) ? $item->client->document_number : '',
                'teléfono cliente final' => isset($item->client) ? $item->client->telephone() : '',
                'iban cliente final' => isset($item->client) ? $item->client->IBAN : '',
                'tipo de calle cliente final' => isset($item->address->streetType) ? $item->address->streetType->name : '',
                'nombre calle cliente final' => isset($item->address) ? $item->address->street_name : '',
                'número calle cliente final' => isset($item->address) ? $item->address->street_number : '',
                'bloque cliente final' => isset($item->address->block) ? $item->address->block : '',
                'escalera bloque final' => isset($item->address->block_staircase) ? $item->address->block_staircase : '',
                'piso cliente final' => isset($item->address->floor) ? $item->address->floor : '',
                'puerta cliente final' => isset($item->address->door) ? $item->address->door : '',
                'código postal cliente final' => isset($item->address) ? $item->address->zip_code : '',
                'población cliente final' => isset($item->address->location) ? $item->address->location->name : '',
                'provincia cliente final' => isset($item->address->location->province) ? $item->address->location->province->name : '',
                'tipo de calle correspondencia cliente final' => isset($item->CorrespondenceAddress->streetType) ? $item->CorrespondenceAddress->streetType->name : '',
                'nombre calle correspondencia cliente final' => isset($item->CorrespondenceAddress) ? $item->CorrespondenceAddress->street_name : '',
                'número calle correspondencia cliente final' => isset($item->CorrespondenceAddress) ? $item->CorrespondenceAddress->street_number : '',
                'bloque cliente correspondencia final' => isset($item->CorrespondenceAddress->block) ? $item->CorrespondenceAddress->block : '',
                'escalera bloque correspondencia final' => isset($item->CorrespondenceAddress->block_staircase) ? $item->CorrespondenceAddress->block_staircase : '',
                'piso cliente correspondencia final' => isset($item->CorrespondenceAddress->floor) ? $item->CorrespondenceAddress->floor : '',
                'puerta cliente correspondencia final' => isset($item->CorrespondenceAddress->door) ? $item->CorrespondenceAddress->door : '',
                'código postal correspondencia cliente final' => isset($item->CorrespondenceAddress) ? $item->CorrespondenceAddress->zip_code : '',
                'población correspondencia cliente final' => isset($item->CorrespondenceAddress->location) ? $item->CorrespondenceAddress->location->name : '',
                'provincia correspondencia cliente final' => isset($item->CorrespondenceAddress->location->province) ? $item->CorrespondenceAddress->location->province->name : '',
                'observaciones del trámite' => isset($item->observation) ? $item->observation : '',
                'fecha finalización trámite' => isset($item->completion_date) ? $item->completion_date : '',
                'estado trámite' => isset($item->status) ? $item->status->name : '',
                'observaciones del tramitador' => isset($item->issuer_observation) ? $item->issuer_observation : '',
                'trámite critico' => isset($item) ? $item->isCritical : '',
                'compañía suministro' => isset($item->product->company) ? $item->product->company->name : '',
                'tarifa acceso' => isset($item->accessRate) ? $item->accessRate->name : '',
                'producto compañía' => isset($item->product) ? $item->product->name : '',
                'consumo anual' => isset($item->annual_consumption) ? $item->annual_consumption : '',
                'CUPS' => isset($item->CUPS) ? $item->CUPS : '',
                'observaciones internas' => isset($item->internal_observation) ? $item->internal_observation : '',
                'compañía suministro anterior' => isset($item->previous_company) ? $item->previous_company->name : '',
                'tipo de vivienda' => isset($item->address->housingType) ? $item->address->housingType->name : '',
                'potencia' => isset($item->potency) ? $item->potency : '',
                'comisión bruta' => isset($item->commission) ? '"' . $item->commission->formatTo('es_ES') . '"' : '',
                'renovación' => isset($item) ? $item->isRenewable : '',
                'fecha activación' => isset($item->activation_date) ? $item->activation_date : '',
                'fecha renovación' => isset($item->renewal_date) ? $item->renewal_date : '',
            ];
        });

        return $test;
    }
    public static function toArrayByIssuer(Collection $set)
    {
        $test = $set->map(function ($item) {
            return [
                'fecha y hora entrada trámite' => isset($item->created_at) ? $item->getCreateAtFormatted() : '',
                'tipo trámite' => isset($item->type) ? $item->type->name : '',
                'suministro' => isset($item->service) ? $item->service->name : '',
                'tipo cliente' => isset($item->client->clientType) ? $item->client->clientType->name : '',
                'cliente final' => isset($item->client) ? $item->client->name . ' ' . $item->client->first_last_name . ' ' . $item->client->second_last_name : '',
                'email cliente final' => isset($item->client) ? $item->client->email : '',
                'tratamiento cliente final' => isset($item->client->title) ? $item->client->title->name : '',
                'tipo de documento cliente final' => isset($item->client->documentType) ? $item->client->documentType->name : '',
                'numero documento cliente final' => isset($item->client) ? $item->client->document_number : '',
                'teléfono cliente final' => isset($item->client) ? $item->client->telephone() : '',
                'iban cliente final' => isset($item->client) ? $item->client->IBAN : '',
                'tipo de calle cliente final' => isset($item->address->streetType) ? $item->address->streetType->name : '',
                'nombre calle cliente final' => isset($item->address) ? $item->address->street_name : '',
                'número calle cliente final' => isset($item->address) ? $item->address->street_number : '',
                'bloque cliente final' => isset($item->address->block) ? $item->address->block : '',
                'escalera bloque final' => isset($item->address->block_staircase) ? $item->address->block_staircase : '',
                'piso cliente final' => isset($item->address->floor) ? $item->address->floor : '',
                'puerta cliente final' => isset($item->address->door) ? $item->address->door : '',
                'código postal cliente final' => isset($item->address) ? $item->address->zip_code : '',
                'población cliente final' => isset($item->address->location) ? $item->address->location->name : '',
                'provincia cliente final' => isset($item->address->location->province) ? $item->address->location->province->name : '',
                'observaciones del trámite' => isset($item->observation) ? $item->observation : '',
                'estado trámite' => isset($item->status) ? $item->status->name : '',
                'observaciones del tramitador' => isset($item->issuer_observation) ? $item->issuer_observation : '',
                'compañía suministro' => isset($item->product->company) ? $item->product->company->name : '',
            ];
        });

        return $test;
    }
}