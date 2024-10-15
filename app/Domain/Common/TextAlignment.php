<?php

namespace App\Domain\Common;

class TextAlignment
{
    public static function className($align = 'left'): string
    {
        return [
            'left' => 'text-left',
            'right' => 'text-right',
            'center' => 'text-center',
        ][$align ?? 'left'];
    }
}