<?php

namespace App\Domain\Tool\Dtos;

class TimeFilterDto
{
    private \DateTime $from;
    private \DateTime $to;

    const ANUAL = 'anual';
    const MENSUAL = 'mensual';
    const SENAMAL = 'semanal';
    const DIARIO = 'diario';

    private $frequencyOptions = [];

    public function __construct()
    {
        $currentYear = date('Y');
        $this->from = new \DateTime("$currentYear-01-01");
        $this->to = new \DateTime(($currentYear + 1) . "-01-01");
    }


    public function setStartDate(\DateTime $date): void
    {
        $this->from = $date;
    }

    public function setEndDate(\DateTime $date): void
    {
        $this->to = $date;
    }


    public function updateFrequencyOptions(): array
    {
        $interval = $this->from->diff($this->to);
        if ($interval) {
            if ($interval->y >= 1) {
                $this->frequencyOptions = ['anual', 'mensual'];
            } elseif ($interval->y === 0 && $interval->m >= 1) {
                $this->frequencyOptions = ['mensual', 'semanal'];
            } elseif ($interval->y === 0 && $interval->m === 0 && $interval->d > 0) {
                $this->frequencyOptions = ['semanal', 'diario'];
            } else {
                $this->frequencyOptions = [];
            }

        } else {
            $this->frequencyOptions = [];
        }

        return $this->frequencyOptions;
    }

    public function getFrequencyOptions(): array
    {
        return $this->frequencyOptions;
    }

    public function getStartDate()
    {
        return $this->from->format('Y-m-d');
    }

    public function getEndDate()
    {
        return $this->to->format('Y-m-d');
    }

}
