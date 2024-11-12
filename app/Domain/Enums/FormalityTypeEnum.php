<?php

namespace App\Domain\Enums;

enum FormalityTypeEnum: string
{
    case ALTA_NUEVA = 'alta nueva';
    case CAMBIO_TITULAR = 'cambio de titular';
    case RENOVACION = 'renovación';
}