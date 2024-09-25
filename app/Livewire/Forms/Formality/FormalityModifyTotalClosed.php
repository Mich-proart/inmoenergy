<?php

namespace App\Livewire\Forms\Formality;

use App\Exceptions\CustomException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityModifyTotalClosed extends Form
{
    public $isRenewable;
    public $activation_date;
    public $renewal_date;
    public $contract_completion_date;
    public $internal_observation;
    public $annual_consumption;
    public $commission;
    public $reason_cancellation_id;
    public $cancellation_observation;

    protected $rules = [
        'activation_date' => 'required|date',
        'contract_completion_date' => 'required|date',
        'isRenewable' => 'nullable|boolean',
        'commission' => 'required|string'
    ];

    protected $messages = [
        'activation_date.required' => 'Debes seleccionar una fecha de activación',
        'activation_date.date' => 'Debes seleccionar una fecha de activación valida',
        'contract_completion_date.required' => 'Debes seleccionar una fecha',
        'contract_completion_date.date' => 'Debes seleccionar una fecha valida',
        'commission.required' => 'Debes rellenar la comision',
        'commission.integer' => 'Debes rellenar la comision',
        'commission.gt' => 'La comision debe ser mayor que 0',
        'commission.numeric' => 'La comision debe ser un valor valido',
    ];

    public function setData($formality)
    {
        $formality->isRenewable == 1 ? $this->isRenewable = true : $this->isRenewable = false;
        $this->commission = $formality->commission ? $this->number_format_spanish($formality->getCommision()) : null;
        $this->annual_consumption = $formality->annual_consumption ? $this->number_format_spanish($formality->annual_consumption) : null;
        $this->activation_date = $formality->activation_date ? date('Y-m-d', strtotime($formality->activation_date)) : null;
        $this->renewal_date = $formality->renewal_date ? date('Y-m-d', strtotime($formality->renewal_date)) : null;
        $this->contract_completion_date = $formality->contract_completion_date ? date('Y-m-d', strtotime($formality->contract_completion_date)) : null;

        $this->reason_cancellation_id = $formality->reason_cancellation_id;
        $this->cancellation_observation = $formality->cancellation_observation;

        $this->internal_observation = $formality->internal_observation;
    }

    public function getDataToUpdate()
    {

        $commission = null;
        $annual_consumption = null;
        if ($this->commission != 0 || $this->commission != null || $this->commission != '') {
            $commission = $this->number_format_english($this->commission);
        }

        if ($this->annual_consumption != 0 && $this->annual_consumption != null && $this->annual_consumption != '') {
            $annual_consumption = intval($this->annual_consumption);
        }

        return [
            'activation_date' => $this->activation_date,
            'isRenewable' => $this->isRenewable,
            'commission' => $commission,
            'contract_completion_date' => $this->contract_completion_date,
            'renewal_date' => $this->renewal_date,
            'annual_consumption' => $annual_consumption,
            'internal_observation' => $this->internal_observation,
            'reason_cancellation_id' => $this->reason_cancellation_id,
            'cancellation_observation' => $this->cancellation_observation
        ];
    }

    private function number_format_spanish($number)
    {
        $result = number_format($number, 4, ',', '.');
        $result = rtrim($result, '0');
        $result = rtrim($result, ',');

        return $result;

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
}
