<?php

namespace App\Livewire\Forms\Formality;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityCancel extends Form
{
    public $reason_cancellation_id;
    public $contract_completion_date;
    public $cancellation_observation;
    public $isCritical;
    public $assignedId;
    public $create_new_one = 0;

    protected $rules = [
        'reason_cancellation_id' => 'required|exists:component_option,id',
        'cancellation_observation' => 'sometimes|nullable|string',
        'contract_completion_date' => 'required|date',

    ];

    protected $messages = [
        'contract_completion_date.required' => 'La fecha de finalización es obligatoria',
        'reason_cancellation_id.required' => 'El motivo de la cancelación es obligatorio',
        'reason_cancellation_id.exists' => 'El motivo de la cancelación es inválido',
    ];

    public function setData($formality)
    {

        $this->reason_cancellation_id = $formality->reason_cancellation_id;
        $this->cancellation_observation = $formality->cancellation_observation;

        if ($formality->contract_completion_date) {
            $this->contract_completion_date = date('Y-m-d', strtotime($formality->contract_completion_date));
        } else {
            $this->contract_completion_date = date('Y-m-d');
        }
    }

    public function getDataUpdate()
    {
        return [
            'reason_cancellation_id' => $this->reason_cancellation_id,
            'cancellation_observation' => $this->cancellation_observation,
            'contract_completion_date' => $this->contract_completion_date,
        ];
    }
}
