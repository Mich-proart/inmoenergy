<?php
namespace App\Domain\Enums;

enum ClientTypeEnum: string
{
    case PERSON = 'Persona física';
    case BUSINESS = 'Persona Jurídica';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}