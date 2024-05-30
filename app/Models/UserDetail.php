<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_detail';
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'first_last_name',
        'second_last_name',
        'document_number',
        'document_type_id',
        'phone',
        'client_type_id',
        'address_id',
        'adviser_assigned_id',
        'responsible_id',
        'user_title_id',
        'housing_type_id',
        'IBAN'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }


    public function adviserAssigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_assigned_id');
    }


    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }


    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'client_type');
    }


    public function housingType(): BelongsTo
    {
        return $this->belongsTo(HousingType::class, 'housing_type');
    }


    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type');
    }

    public function title(): BelongsTo
    {
        return $this->belongsTo(UserTitle::class, 'user_title');
    }

}
