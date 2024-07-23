<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use \NumberFormatter;

class Money implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // return $value;
        if (!$value) {
            return \Brick\Money\Money::of(0, 'EUR');
        }
        return \Brick\Money\Money::of($value, 'EUR');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value instanceof \Brick\Money\Money) {
            return $value;
        }
        return $value->getMinorAmount()->toInt();
    }
}
