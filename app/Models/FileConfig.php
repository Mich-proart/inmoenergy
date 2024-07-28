<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileConfig extends Model
{
    use HasFactory;

    protected $table = 'file_config';

    public $timestamps = false;

    protected $fillable = ['name', 'is_available', 'is_required', 'component_option_id'];


    public function componentOption(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'component_option_id');
    }


}
