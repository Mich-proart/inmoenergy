<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Office extends Model
{
    use HasFactory;

    protected $table = 'office';
    protected $fillable = ['name', 'business_group_id', 'is_available'];


    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }
}
