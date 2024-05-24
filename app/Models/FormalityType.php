<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormalityType extends Model
{
    use HasFactory;

    protected $table = 'formality_type';

    public $timestamps = false;

    protected $fillable = ['name'];
}
