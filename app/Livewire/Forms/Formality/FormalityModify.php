<?php

namespace App\Livewire\Forms\Formality;

use App\Exceptions\CustomException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityModify extends Form
{
    public $assigned_observation;

    public $CUPS;

    public $access_rate_id;

    public $annual_consumption;

    public bool $canClientEdit = false;
    public $internal_observation;

    public $product_id;
    public $previous_company_id;


    public $potency;

    public $user_assigned_id;


    public function setData($formality)
    {
        $this->assigned_observation = $formality->assigned_observation ?? '';
        $this->CUPS = $formality->CUPS ?? '';
        $this->access_rate_id = $formality->access_rate_id ?? null;
        $this->annual_consumption = $formality->annual_consumption ?? null;
        $this->canClientEdit = $formality->canClientEdit ?? false;
        $this->internal_observation = $formality->internal_observation ?? '';
        $this->product_id = $formality->product_id ?? null;
        $this->potency = $formality->potency ? $this->number_format_spanish($formality->potency) : null;
        $this->previous_company_id = $formality->previous_company_id ?? null;
        $this->user_assigned_id = $formality->user_assigned_id ?? null;
    }

    protected $rules = [
        'assigned_observation' => 'sometimes|nullable|string',
        'canClientEdit' => 'sometimes|nullable|boolean',
        'internal_observation' => 'sometimes|nullable|string',
        'product_id' => 'required|integer|exists:product,id',
        'previous_company_id' => 'sometimes|nullable|integer|exists:company,id',
    ];

    protected $messages = [
        'CUPS' => 'Debes rellenar el CUPS',
        'CUPS.string' => 'Debes rellenar el CUPS',
        'CUPS.min' => 'Minimo 20 caracteres',
        'CUPS.max' => 'Maximo 22 caracteres',
        'access_rate_id.required' => 'Debes seleccionar una tarifa de acceso',
        'access_rate_id.integer' => 'Debes seleccionar una tarifa de acceso',
        'access_rate_id.exists' => 'Debes seleccionar una tarifa de acceso existente',
        'annual_consumption.required' => 'Debes rellenar el consumo anual',
        'annual_consumption.integer' => 'Debes rellenar el consumo anual valido',
        'product_id.required' => 'Debes seleccionar un producto',
        'product_id.integer' => 'Debes seleccionar un producto',
        'product_id.exists' => 'Debes seleccionar un proyecto existente',
    ];

    public function getDataToUpdate()
    {

        $access_rate_id = null;
        $user_assigned_id = null;
        $potency = null;

        if ($this->access_rate_id != 0 || $this->access_rate_id != null || $this->access_rate_id != '') {
            $access_rate_id = $this->access_rate_id;
        }

        if ($this->user_assigned_id != 0 || $this->user_assigned_id != null || $this->user_assigned_id != '') {
            $user_assigned_id = $this->user_assigned_id;
        }

        if ($this->potency != 0 || $this->potency != null || $this->potency != '') {
            $potency = $this->number_format_english($this->potency);
        }

        return [
            'assigned_observation' => $this->assigned_observation,
            'CUPS' => $this->CUPS ?? null,
            'access_rate_id' => $access_rate_id,
            'annual_consumption' => (int) $this->annual_consumption ?? null,
            'canClientEdit' => $this->canClientEdit,
            'internal_observation' => $this->internal_observation,
            'product_id' => (int) $this->product_id ?? null,
            'potency' => $potency, // (float) $this->potency ?? null,
            'previous_company_id' => (int) $this->previous_company_id ?? null,
            'user_assigned_id' => $user_assigned_id
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
