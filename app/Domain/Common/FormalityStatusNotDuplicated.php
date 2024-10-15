<?php

namespace App\Domain\Common;

class FormalityStatusNotDuplicated
{
    public static function getList()
    {
        return [
            'pendiente asignación',
            'asignado',
            'en curso',
            'tramitado'
        ];
    }
}