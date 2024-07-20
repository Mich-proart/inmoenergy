<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentOption extends Model
{
    use HasFactory;

    protected $table = 'component_option';

    public $timestamps = false;

    protected $fillable = ['name', 'component_id', 'description', 'is_available'];


    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
