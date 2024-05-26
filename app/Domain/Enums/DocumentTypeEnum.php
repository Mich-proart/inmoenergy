<?php
namespace App\Domain\Enums;

enum DocumentTypeEnum: string
{
    case DNI = 'DNI';
    case PASSPORT = 'Passport';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}