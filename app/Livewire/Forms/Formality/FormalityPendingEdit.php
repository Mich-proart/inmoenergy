<?php

namespace App\Livewire\Forms\Formality;

use App\Exceptions\CustomException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityPendingEdit extends Form
{
    public $formalityId;
    public $activation_date;
    public bool $isRenewable = true;

    public $commission;
    public $contract_completion_date;

    // public $renewal_date;

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'activation_date' => 'required|date',
        'contract_completion_date' => 'required|date',
        'isRenewable' => 'nullable|boolean',
        'commission' => 'required|string'
        //'renewal_date' => 'nullable|date',
    ];

    protected $messages = [
        'formalityId.required' => 'Debes seleccionar un tramite',
        'formalityId.exists' => 'Debes seleccionar un tramite existente',
        'activation_date.required' => 'Debes seleccionar una fecha de activación',
        'activation_date.date' => 'Debes seleccionar una fecha de activación valida',
        'contract_completion_date.required' => 'Debes seleccionar una fecha',
        'contract_completion_date.date' => 'Debes seleccionar una fecha valida',
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

        $commission = null;
        if ($this->commission != 0 || $this->commission != null || $this->commission != '') {
            $commission = $this->number_format_english($this->commission);
        }

        return [
            'activation_date' => $this->activation_date,
            'isRenewable' => $this->isRenewable,
            'commission' => $commission,
            'contract_completion_date' => $this->contract_completion_date
        ];
    }

    private function number_format_english($number)
    {
        $number = preg_replace('/[^0-9,]/', '', $number);
        $number = str_replace(',', '.', $number);


        if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $number)) {
            throw new CustomException('Invalid number format');
        }

        return floatval($number);
    }
    private function number_format_spanish($number)
    {
        $result = number_format($number, 4, ',', '.');
        $result = rtrim($result, '0');
        $result = rtrim($result, ',');

        return $result;

    }
}
