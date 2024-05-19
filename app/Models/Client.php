<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';

    protected $fillable = [
        'first_name',
        'last_name',
        'second_last_name',
        'email',
        'phone',
        'document_number',
        'bank_account_number',
        'address_id',
        'document_type_id'
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }


}
