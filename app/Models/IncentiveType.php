<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncentiveType extends Model
{
    use HasFactory;

    protected $table = 'incentive_type';

    public $timestamps = false;

    protected $fillable = ['name'];
}
