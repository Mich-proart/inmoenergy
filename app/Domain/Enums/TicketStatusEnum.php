<?php

namespace App\Domain\Enums;

enum TicketStatusEnum: string
{
    case PENDIENTE = 'pendiente asignación';
    case ASIGNADO = 'asignado';
    case EN_CURSO = 'en curso';

    case PENDIENTE_CLIENTE = 'pendiente de cliente';
    case PENDIENTE_VALIDACION = 'pendiente validación';
    case RESUELTO = 'resuelto';
}