<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';

    protected $fillable = [
        'name',
        'first_last_name',
        'second_last_name',
        'email',
        'client_type_id',
        'document_type_id',
        'document_number',
        'phone',
        'IBAN',
        'user_title_id',
        'address_id',
        'isActive',
        'disabled_at'
    ];


    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'client_type_id');
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'document_type_id');
    }

    public function title(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'user_title_id');
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

}