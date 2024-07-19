<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Component extends Model
{
    use HasFactory;

    protected $table = 'component';

    public $timestamps = false;

    protected $fillable = ['name', 'program_id', 'alias', 'description'];


    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
