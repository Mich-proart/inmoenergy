<?php

namespace App\Domain\Enums;

enum FileConfigEnum: string
{
    case DNI = 'DNI (Ambas caras)';
    case CONTRATOALQUILER = 'contrato de alquiler o contrato de compraventa';
    case AUTORIZACIONINMOENERGY = 'autorización hacia InmoEnergy';
    case CONTRATOSUMINISTRO = 'contrato del suministro';
}
