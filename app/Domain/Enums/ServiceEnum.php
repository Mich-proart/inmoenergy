<?php

namespace App\Domain\Enums;

enum ServiceEnum: string
{
    case LUZ = 'luz';
    case AGUA = 'agua';
    case GAS = 'gas';
    case FIBRA = 'fibra';
    case ALARMA = 'alarma';
}

