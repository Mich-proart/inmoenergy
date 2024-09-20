<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'name_spanish',
        'nom',
        'iso2',
        'iso3',
        'phone_code',
    ];
}
