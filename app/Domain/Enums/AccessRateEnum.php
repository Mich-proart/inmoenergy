<?php

namespace App\Domain\Enums;

enum AccessRateEnum: string
{
    case DOS = '2.0';
    case TRES = '3.0';
    case RL1 = 'RL1';
    case RL2 = 'RL2';
    case RL3 = 'RL3';
}