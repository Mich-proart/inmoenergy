<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';

    public $timestamps = false;

    protected $fillable = ['name', 'section_id', 'image', 'route', 'description'];


    public function section(): BelongsTo
    {
        return $this->belongsTo(section::class);
    }
}
