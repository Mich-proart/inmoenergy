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


    //public $commission;

    public $potency;


    public function setData($formality)
    {
        $this->issuer_observation = $formality->issuer_observation ?? '';
        $this->CUPS = $formality->CUPS ?? '';
        $this->access_rate_id = $formality->access_rate_id ?? '';
        $this->annual_consumption = $formality->annual_consumption ?? '';
        $this->canClientEdit = $formality->canClientEdit ?? false;
        $this->internal_observation = $formality->internal_observation ?? '';
        $this->product_id = $formality->product_id ?? '';
        //$this->commission = (string) $formality->commission->getAmount() ?? '';
        $this->potency = $formality->potency ?? '';
    }

    protected $rules = [
        'issuer_observation' => 'sometimes|nullable|string',
        'CUPS' => 'required|string|min:20|max:22',
        'access_rate_id' => 'required|integer|exists:component_option,id',
        'annual_consumption' => 'required|integer',
        'canClientEdit' => 'sometimes|nullable|boolean',
        'internal_observation' => 'sometimes|nullable|string',
        'product_id' => 'required|integer|exists:product,id',
        //'commission' => 'required|numeric|gt:0',
        'potency' => 'required|numeric|gt:0',
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
        /*
        'commission.required' => 'Debes rellenar la comision',
        'commission.integer' => 'Debes rellenar la comision',
        'commission.gt' => 'La comision debe ser mayor que 0',
        'commission.numeric' => 'La comision debe ser un valor valido',
        */
        'potency.required' => 'Debes rellenar la potencia',
        'potency.numeric' => 'La potencia debe ser un valor valido',
        'potency.gt' => 'La potencia debe ser mayor que 0',

    ];
    public $rules_to_update = [
        'issuer_observation' => 'sometimes|nullable|string',
        'CUPS' => 'sometimes|nullable|string',
        'access_rate_id' => 'sometimes|nullable|integer|exists:component_option,id',
        'annual_consumption' => 'sometimes|nullable|integer',
        'canClientEdit' => 'sometimes|nullable|boolean',
        'internal_observation' => 'sometimes|nullable|string',
        'product_id' => 'sometimes|nullable|integer|exists:product,id',
        // 'commission' => 'sometimes|nullable|integer',
        'potency' => 'sometimes|nullable|integer',
    ];


    public function getDataToUpdate()
    {

        return [
            'issuer_observation' => $this->issuer_observation,
            'CUPS' => $this->CUPS,
            'access_rate_id' => $this->access_rate_id,
            'annual_consumption' => $this->annual_consumption,
            'canClientEdit' => $this->canClientEdit,
            'internal_observation' => $this->internal_observation,
            'product_id' => $this->product_id,
            // 'commission' => $this->commission,
            'potency' => $this->potency,
        ];
    }
}
