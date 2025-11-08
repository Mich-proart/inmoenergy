<?php

namespace App\Livewire\Forms\Formality;

use App\Exceptions\CustomException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormalityComissionEdit extends Form
{
    public $formalityId;

    public $commission;

    protected $formalityService;


    protected $rules = [
        'commission' => 'required|string'
    ];

    protected $messages = [
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
            'commission' => $commission,
        ];
    }

    public function number_format_english($number)
    {
        $number = preg_replace('/[^0-9,]/', '', $number);
        $number = str_replace(',', '.', $number);


        if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $number)) {
            throw new CustomException('Invalid number format');
        }

        return floatval($number);
    }
    public function number_format_spanish($number)
    {
        $result = number_format($number, 4, ',', '.');
        $result = rtrim($result, '0');
        $result = rtrim($result, ',');

        return $result;

    }
}
