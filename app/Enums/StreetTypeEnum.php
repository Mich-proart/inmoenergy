<?php

namespace App\Enums;

enum StreetTypeEnum: string
{
    case avenida = 'avenida';
    case calle = 'calle';
    case pasaje = 'pasaje';
    case paseo = 'paseo';
}