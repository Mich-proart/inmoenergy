<?php

namespace App\Domain\Tool\Services;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Enums\ServiceEnum;
use App\Models\Formality;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Carbon;

class StatisticService
{

    const ISSUER = 'user_issuer_id';
    const ASSIGNED = 'user_assigned_id';

    private $searchBasedOn;

    public function __construct($searchBasedOn = self::ASSIGNED)
    {
        $this->setSearchBasedOn($searchBasedOn);
    }

    public function setSearchBasedOn($searchBasedOn)
    {
        if ($searchBasedOn !== self::ISSUER && $searchBasedOn !== self::ASSIGNED) {
            throw new InvalidArgumentException("Invalid value for searchBasedOn. Allowed values are '" . self::ISSUER . "' or '" . self::ASSIGNED . "'.");
        }
        $this->searchBasedOn = $searchBasedOn;
    }


    public function search($usersIds = [], $from, $to, $frequency, $services = []): array
    {
        $query = Formality::with('service', 'issuer', 'assigned');

        if (!empty($usersIds)) {
            $query->whereIn($this->searchBasedOn, $usersIds);
        }

        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }

        if (!empty($services)) {
            $query->whereIn('service_id', $services);
        } else {
            $query->whereHas('service', function ($q) {
                $q->whereIn('name', [ServiceEnum::AGUA->value, ServiceEnum::GAS->value, ServiceEnum::LUZ->value]);
            });
        }

        $formalities = $query->whereHas('status', function ($q) {
            $q->whereIn('name', [FormalityStatusEnum::TRAMITADO, FormalityStatusEnum::EN_VIGOR]);
        })->get();
        return $this->formatDataForChart($formalities, $frequency);
    }


    private function formatDataForChart($formalities, $frequency): array
    {
        return [
            'doughnutChart' => $this->doughnutChart($formalities),
            'formalityCount' => $formalities->count(),
            'timeformalityAvg' => $this->getAverage($formalities)
        ];
    }

    private function doughnutChart($formalities)
    {

        return $formalities->groupBy('service_id')->map(function ($group) {
            return $group->count();
        });
    }

    private function horizontalBarChart($formalities)
    {

        return $formalities->groupBy($this->searchBasedOn)->map(function ($group) {
            return $group->count();
        })->sortDesc();

    }

    private function verticalBarChart($formalities, $frequency)
    {

    }

    private function getAverage($formality)
    {

        return $formality->avg(function ($formality) {
            return Carbon::parse($formality->contract_completion_date)->diffInMinutes(Carbon::parse($formality->created_at));
        });
    }

}
