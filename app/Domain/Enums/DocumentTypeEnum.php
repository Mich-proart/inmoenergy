<?php
namespace App\Domain\Enums;

enum DocumentTypeEnum: string
{
    case DNI = 'DNI';
    case PASSPORT = 'passport';
    case CIF = 'CIF';
    case NIE = 'NIE';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

class DocumentRule
{
    public static $DNI = 'required|string|spanish_personal_id';
    public static $pasaporte = 'required|string|passport';
    public static $CIF = 'required|string|cif';
    public static $NIE = 'required|string|nie';
}