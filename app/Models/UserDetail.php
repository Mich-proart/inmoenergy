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
        'document_type',
        'phone',
        'client_type',
        'address_id',
        'adviser_assigned_id',
        'responsible_id',
        'user_title',
        'housing_type',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'document_type' => DocumentTypeEnum::class,
        'client_type' => ClientTypeEnum::class,
        'user_title' => UserTitleEnum::class,
        'housing_type' => HousingTypeEnum::class,
    ];
}
