<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormalityStatus extends Model
{
    use HasFactory;

    protected $table = 'formality_status';

    public $timestamps = false;

    protected $fillable = ['name'];
}
