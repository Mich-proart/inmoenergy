<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = [
        'name',
        'filename',
        'mime_type',
        'folder',
        'config_id'
    ];

    /*
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
        */

    public function config(): BelongsTo
    {
        return $this->belongsTo(FileConfig::class, 'config_id');
    }

    public function formalities()
    {
        return $this->morphedByMany(Formality::class, 'fileable');
    }

    public function clients()
    {
        return $this->morphedByMany(Client::class, 'fileable');
    }
}
