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


    public function search($usersIds = [], $services = [], $from, $to, string|null $frequency, bool $groupByService = false): array
    {
        $query = Formality::with('service', 'issuer', 'assigned');

        $query->whereIn($this->searchBasedOn, $usersIds);

        if ($from && $to) {
            $this->from = $from;
            $query->whereBetween('created_at', [$from, $to]);
        }

        $query->whereIn('service_id', $services);

        // New prefilter: exclude formalities with status "KO"
        $formalities = $query->whereHas('status', function ($q) {
            $q->where('name', '!=', FormalityStatusEnum::KO->value);
        })->get();
        
        return $this->formatDataForChart($formalities, $frequency, $query, $groupByService);
    }



    private function formatDataForChart(Collection $formalities, string|null $frequency, Builder $builder, bool $groupByService = false): array
    {
        return [
            'doughnutChart' => $this->doughnutChart($formalities),
            'horizontalBarChart' => $this->horizontalBarChart($formalities, $groupByService),
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

    private function horizontalBarChart(Collection $formalities, bool $groupByService = false)
    {
        $groupBy = $groupByService ? 'service_id' : $this->searchBasedOn;
        
        return $formalities->groupBy($groupBy)->map(function ($items) use ($groupByService) {
            // Active/completed statuses (including Baja as per requirement point 26)
            $activeCount = $items->filter(function ($item) {
                return in_array($item->status->name, [
                    FormalityStatusEnum::PENDIENTE->value,
                    FormalityStatusEnum::ASIGNADO->value,
                    FormalityStatusEnum::EN_CURSO->value,
                    FormalityStatusEnum::TRAMITADO->value,
                    FormalityStatusEnum::EN_VIGOR->value,
                    FormalityStatusEnum::FINALIZADO->value,
                    FormalityStatusEnum::BAJA->value  // Added as per point 26
                ]);
            })->count();
            
            // Baja status count (for separate tracking)
            $bajaCount = $items->filter(function ($item) {
                return $item->status->name === FormalityStatusEnum::BAJA->value;
            })->count();
            
            // Difference (activeCount now includes Baja, so this is the count excluding Baja)
            $differenceCount = $activeCount - $bajaCount;
            
            // Determine label based on grouping
            if ($groupByService) {
                $label = ucfirst($items->first()->service->name);
            } else {
                $label = $this->formatUserName($this->searchBasedOn === self::ASSIGNED ? $items->first()->assigned : $items->first()->issuer);
            }
            
            return [
                'user' => $label,
                'activeCount' => $activeCount,
                'bajaCount' => $bajaCount,
                'differenceCount' => $differenceCount
            ];
        })->sortByDesc('activeCount')->values();

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
