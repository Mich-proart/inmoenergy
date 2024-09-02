<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Permission\Models\Role;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';

    public $timestamps = false;

    protected $fillable = ['name', 'section_id', 'image', 'route', 'description', 'placed_in'];

    public $count = 0;

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }


    public function section(): BelongsTo
    {
        return $this->belongsTo(section::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'program_role', 'program_id', 'role_id');
    }

}
