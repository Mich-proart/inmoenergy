<?php

namespace App\Domain\Enums;

enum FormalityTypeEnum: string
{
    case ALTA_NUEVA = 'Alta Nueva';
    case CAMBIO_TITULAR = 'Cambio de Titular';
}