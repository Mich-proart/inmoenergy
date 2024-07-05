<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class modifyFormalityFields extends Form
{
    public $issuer_observation;

    public $CUPS;

    public $access_rate_id;

    public $annual_consumption;

    public bool $canClientEdit = false;
    public $internal_observation;

    public $product_id;

    public $company_id;

    public $commission;

    public $potential;

    public function setData($formality)
    {
        $this->issuer_observation = $formality->issuer_observation;
    }

    protected $rules = [
        'issuer_observation' => 'sometimes|nullable|string',
        'CUPS' => 'required|string',
        'access_rate_id' => 'required|integer|exists:access_rate,id',
        'annual_consumption' => 'required|integer',
        'canClientEdit' => 'sometimes|nullable|boolean',
        'internal_observation' => 'sometimes|nullable|string',
        'product_id' => 'required|integer',
        'company_id' => 'required|integer',
        'commission' => 'required|integer',
        'potential' => 'required|integer',
    ];
}
