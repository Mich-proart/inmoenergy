<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComponentOption extends Model
{
    use HasFactory;

    protected $table = 'component_option';

    public $timestamps = false;

    protected $fillable = ['name', 'component_id', 'option_id', 'description', 'is_available'];


    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'option_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ComponentOption::class, 'option_id');
    }

    public function formalities(): HasMany
    {
        return $this->hasMany(Formality::class);
    }
}
