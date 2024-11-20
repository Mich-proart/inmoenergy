<?php

namespace App\Domain\Tool\Services;

use App\Domain\Enums\FormalityStatusEnum;
use App\Models\Formality;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StatisticService
{

    const ISSUER = 'user_issuer_id';
    const ASSIGNED = 'user_assigned_id';

    private $searchBasedOn;

    private $from;

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


    public function search($usersIds = [], $services = [], $from, $to, string|null $frequency): array
    {
        $query = Formality::with('service', 'issuer', 'assigned');

        $query->whereIn($this->searchBasedOn, $usersIds);

        if ($from && $to) {
            $this->from = $from;
            $query->whereBetween('created_at', [$from, $to]);
        }

        $query->whereIn('service_id', $services);

        $formalities = $query->whereHas('status', function ($q) {
            $q->whereIn('name', [FormalityStatusEnum::TRAMITADO, FormalityStatusEnum::EN_VIGOR]);
        })->get();
        return $this->formatDataForChart($formalities, $frequency, $query);
    }


    private function formatDataForChart(Collection $formalities, string|null $frequency, Builder $builder): array
    {
        return [
            'doughnutChart' => $this->doughnutChart($formalities),
            'horizontalBarChart' => $this->horizontalBarChart($formalities),
            'verticalBarChart' => !empty($frequency) ? $this->verticalBarChart($builder, $frequency) : null,
            'totalCount' => $formalities->count(),
            'timeAvg' => $this->getAverage($formalities)
        ];
    }

    private function doughnutChart(Collection $formalities)
    {
        return $formalities->groupBy('service_id')->map(function ($items) {
            return [
                'service' => $items->first()->service->name,
                'count' => $items->count(),
            ];
        })->sortByDesc('count')->values();
    }

    private function horizontalBarChart(Collection $formalities)
    {
        return $formalities->groupBy($this->searchBasedOn)->map(function ($items) {
            return [
                'user' => $this->formatUserName($this->searchBasedOn === self::ASSIGNED ? $items->first()->assigned : $items->first()->issuer),
                'count' => $items->count()
            ];
        })->sortByDesc('count')->values();

    }

    private function verticalBarChart(Builder $query, string $frequency)
    {
        $set = FormalityFrequency::execute($query, $frequency);
        $data = $set->groupBy(function ($item) {
            return $item->period;
        })->map(function ($group, $period) {
            return [
                'period' => $period,
                'items' => $group->map(function ($item) {
                    return [
                        'service' => $item->service,
                        'count' => $item->count
                    ];
                })->values()->all()
            ];
        })->values()->all();
        return [
            'frequency' => $frequency,
            'from' => $this->from,
            'data' => $data
        ];
    }

    private function getAverage($formality)
    {
        $averageInMin = $formality->avg(function ($formality) {
            return Carbon::parse($formality->contract_completion_date)->diffInMinutes(Carbon::parse($formality->created_at));
        });
        $avgInHours = $averageInMin / 60;

        return round($avgInHours, 2);
    }

    private function formatUserName(User $user): string
    {
        return $user->name . ' ' . $user->first_last_name . ' ' . $user->second_last_name;
    }

}
