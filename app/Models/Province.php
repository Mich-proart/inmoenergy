<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $table = 'province';
    public $timestamps = false;


    protected $fillable = [
        'name',
        'region_id',
        'created_at',
        'updated_at',
    ];


    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }


    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
