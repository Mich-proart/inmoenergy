<?php

namespace App\Domain\Enums;

enum FormalityStatusEnum: string
{
    case PENDIENTE = 'pendiente asignación';
    case ASIGNADO = 'asignado';
    case REVISANDO_DOCUMENTACIÓN = 'revisando documentación';
    case EN_CURSO = 'en curso';

    case TRAMITADO = 'tramitado';
    case EN_VIGOR = 'en vigor';
    case KO = 'K.O.';
    case INCIDENCIA = 'incidencia';
}