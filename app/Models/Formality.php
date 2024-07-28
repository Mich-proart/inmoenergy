<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Formality extends Model
{
    use HasFactory;

    protected $table = 'formality';

    protected $fillable = [
        'user_client_id',
        'user_issuer_id',
        'user_Assigned_id',
        'observation',
        'canClientEdit',
        'isCritical',
        'isRenewable',
        'assignment_date',
        'completion_date',
        'renewal_date',
        'activation_date',
        'is_active',
        'CUPS',
        'internal_observation',
        'annual_consumption',
        'isClientAddress',
        'address_id',
        'formality_type_id',
        'status_id',
        'access_rate_id',
        'service_id',
        'issuer_observation',
        'assigned_observation',
        'correspondence_address_id',
        'isSameCorrespondenceAddress',
        'product_id',
        'commission',
        'potency',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_client_id');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_issuer_id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_Assigned_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function CorrespondenceAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'correspondence_address_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'formality_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'service_id');
    }

    public function accessRate(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'access_rate_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected $casts = [
        'commission' => Money::class
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
