<?php

namespace App\Domain\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'super-admin';
    case COMERCIAL = 'comercial';
    case INMOBILIARIA = 'inmobiliaria';
    // case RYMES = 'rymes';
    // case OFFERCOMMER = 'offer-commer';
}