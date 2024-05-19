<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $fillable = [
        'city_id',
        'complement',
        'street_number',
        'zip_code',
        'bloq',
        'escal',
        'piso',
        'puert',
        'another',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
