<?php
namespace App\Domain\Enums;

enum DocumentTypeEnum: string
{
    case DNI = 'DNI';
    case PASSPORT = 'Passport';
}