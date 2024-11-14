<?php

namespace App\Domain\Tool\Services;

use App\Domain\Tool\Dtos\TimeFilterDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class FormalityFrequency
{
    public static function execute(Builder $builder, string $frequency)
    {
        switch ($frequency) {
            case TimeFilterDto::ANUAL:
                $builder->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as period'),
                    'service_id',
                    'service.name as service',
                    DB::raw('COUNT(*) as count')
                );
                break;
            case TimeFilterDto::MENSUAL:
                $builder->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
                    'service_id',
                    'service.name as service',
                    DB::raw('COUNT(*) as count')
                );
                break;
            case TimeFilterDto::SENAMAL:
                $builder->select(
                    DB::raw('WEEK(created_at, 1) as period'),
                    'service_id',
                    'service.name as service',
                    DB::raw('COUNT(*) as count')
                );
                break;
            case TimeFilterDto::DIARIO:
                $builder->select(
                    DB::raw('DATE(created_at) as period'),
                    'service_id',
                    'service.name as service',
                    DB::raw('COUNT(*) as count')
                );
                break;
        }

        return $builder
            ->join('component_option as service', 'service.id', '=', 'formality.service_id')
            ->groupBy('period', 'service_id', 'service')
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->orderBy('service', 'desc')
            ->get();
    }
}
