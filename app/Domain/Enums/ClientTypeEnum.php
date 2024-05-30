<?php
namespace App\Domain\Enums;

enum ClientTypeEnum: string
{
    case PERSON = 'persona física';
    case BUSINESS = 'persona jurídica';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}