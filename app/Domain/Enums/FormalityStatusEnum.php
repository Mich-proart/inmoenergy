<?php

namespace App\Domain\Enums;

enum formalityStatusEnum: string
{
    case PENDIENTE = 'Pendiente';
    case ASIGNADO = 'Asignado';
    case REVISANDO_DOCUMENTACIÓN = 'Revisando Documentación';
    case EN_CURSO = 'En curso';

    case TRAMITADO = 'Tramitado';
    case EN_VIGOR = 'En Vigor';
    case KO = 'KO';
    case INCIDENCIA = 'Incidencia';
}