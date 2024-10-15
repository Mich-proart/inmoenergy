<?php

namespace App\Domain\Formality\Services;


use App\Domain\Enums\FormalityStatusEnum;
use App\Models\Formality;
use App\Models\Status;

class CreateFormalityService
{

    private int $user_issuer_id;
    private int $client_id;

    private int $address_id;

    private int|null $correspondence_address_id = null;

    private Status $formalityStatus;

    public function __construct()
    {
        $this->formalityStatus = Status::where('name', FormalityStatusEnum::PENDIENTE->value)->first();
    }

    public function execute(int $serviceId, int $formalitytypeId, ?string $observation)
    {

        return Formality::create([
            'client_id' => $this->client_id,
            'user_issuer_id' => $this->user_issuer_id,
            'service_id' => $serviceId,
            'observation' => $observation,
            'formality_type_id' => $formalitytypeId,
            'address_id' => $this->address_id,
            'correspondence_address_id' => $this->correspondence_address_id,
            'status_id' => $this->formalityStatus->id
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

    public function setCorrespondenceAddressId(int $correspondence_address_id)
    {
        $this->correspondence_address_id = $correspondence_address_id;
    }
}