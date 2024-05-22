<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StreetType extends Model
{
    use HasFactory;

    protected $table = 'street_type';
    public $timestamps = false;

    protected $fillable = ['name'];


    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
