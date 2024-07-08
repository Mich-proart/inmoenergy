<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class editPendingFormalityFields extends Form
{
    public $formalityId;
    public $activation_date;
    public bool $isRenewable = false;

    // public $renewal_date;

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'activation_date' => 'required|date',
        'isRenewable' => 'nullable|boolean',
        //'renewal_date' => 'nullable|date',
    ];

    public function setId($formalityId)
    {
        $this->formalityId = $formalityId;
    }

    public function getDataToUpdate()
    {

        return [
            'activation_date' => $this->activation_date,
            'isRenewable' => $this->isRenewable,
        ];
    }
}
