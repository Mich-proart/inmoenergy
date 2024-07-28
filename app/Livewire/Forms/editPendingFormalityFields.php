<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class editPendingFormalityFields extends Form
{
    public $formalityId;
    public $activation_date;
    public bool $isRenewable = true;

    public $commission;

    // public $renewal_date;

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'activation_date' => 'required|date',
        'isRenewable' => 'nullable|boolean',
        'commission' => 'required|numeric|gt:0'
        //'renewal_date' => 'nullable|date',
    ];

    protected $messages = [
        'formalityId.required' => 'Debes seleccionar un tramite',
        'formalityId.exists' => 'Debes seleccionar un tramite existente',
        'activation_date.required' => 'Debes seleccionar una fecha de activación',
        'activation_date.date' => 'Debes seleccionar una fecha de activación valida',
        'commission.required' => 'Debes rellenar la comision',
        'commission.integer' => 'Debes rellenar la comision',
        'commission.gt' => 'La comision debe ser mayor que 0',
        'commission.numeric' => 'La comision debe ser un valor valido',
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
            'commission' => $this->commission,
        ];
    }
}
