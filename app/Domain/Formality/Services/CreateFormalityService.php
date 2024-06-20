<?php

namespace App\Domain\Formality\Services;


use App\Domain\Enums\FormalityStatusEnum;
use App\Models\Formality;
use App\Models\FormalityStatus;

class CreateFormalityService
{

    private int $user_issuer_id;
    private int $client_id;

    private int $address_id;

    private FormalityStatus $formalityStatus;

    public function __construct()
    {
        $this->formalityStatus = FormalityStatus::where('name', FormalityStatusEnum::PENDIENTE->value)->first();
    }

    public function execute(int $serviceId, int $formalitytypeId, ?string $observation)
    {
        return Formality::create([
            'user_client_id' => $this->client_id,
            'user_issuer_id' => $this->user_issuer_id,
            'service_id' => $serviceId,
            'observation' => $observation,
            'formality_status_id' => $this->formalityStatus->id,
            'formality_type_id' => $formalitytypeId,
            'address_id' => $this->address_id
        ]);
    }

    public function setUserIssuerId(int $user_issuer_id)
    {
        $this->user_issuer_id = $user_issuer_id;
    }

    public function setClientId(int $client_id)
    {
        $this->client_id = $client_id;
    }

    public function setAddresId(int $address_id)
    {
        $this->address_id = $address_id;
    }
}