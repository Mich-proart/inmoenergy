<?php

namespace App\Domain\Services\Formality;

use App\Domain\Enums\formalityStatusEnum;
use App\Models\Formality;
use App\Models\FormalityStatus;

class CreateFormalityService
{

    private int $user_issuer_id;
    private int $client_id;

    private FormalityStatus $formalityStatus;

    public function __construct()
    {
        $this->formalityStatus = FormalityStatus::where('name', formalityStatusEnum::PENDIENTE->value)->first();
    }

    public function execute(int $serviceId, int $formalitytypeId, ?string $observation)
    {
        return Formality::create([
            'user_client_id' => $this->client_id,
            'user_issuer_id' => $this->user_issuer_id,
            'service_id' => $serviceId,
            'observation' => $observation,
            'formality_status_id' => $this->formalityStatus->id,
            'formality_type_id' => $formalitytypeId
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
}