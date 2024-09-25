<?php

namespace App\Domain\Enums;

enum FormalityStatusEnum: string
{
    case PENDIENTE = 'pendiente asignación';
    case ASIGNADO = 'asignado';
    case EN_CURSO = 'en curso';

    case TRAMITADO = 'tramitado';
    case FINALIZADO = 'finalizado';
    case BAJA = 'baja';
    case EN_VIGOR = 'en vigor';
    case KO = 'K.O.';
}