<?php

namespace App\Domain\Enums;

enum HousingTypeEnum: string
{
    case living_place = 'vivienda';
    case local = 'local';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}