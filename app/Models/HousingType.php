<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingType extends Model
{
    use HasFactory;

    protected $table = 'housing_type';

    public $timestamps = false;

    protected $fillable = ['name'];
}
