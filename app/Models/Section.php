<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;

class Section extends Model
{
    use HasFactory;

    protected $table = 'section';

    public $timestamps = false;

    protected $fillable = ['name'];


    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
