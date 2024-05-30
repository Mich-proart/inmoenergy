<?php
namespace App\Domain\Enums;

enum UserTitleEnum: string
{
    case Sr = 'Sr.';
    case Sra = 'Sra.';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}

