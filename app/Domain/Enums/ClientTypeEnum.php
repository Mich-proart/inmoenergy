<?php
namespace App\Domain\Enums;

enum ClientTypeEnum: string
{
    case PERSON = 'Persona física';
    case BUSINESS = 'Persona Jurídica';
}