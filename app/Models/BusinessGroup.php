<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessGroup extends Model
{
    use HasFactory;

    protected $table = 'business_group';

    protected $fillable = ['name', 'is_available'];

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }
}
