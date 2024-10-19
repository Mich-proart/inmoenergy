<?php

namespace App\Models;

use App\Casts\Money;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Formality extends Model
{
    use HasFactory;

    protected $table = 'formality';

    protected $fillable = [
        'client_id',
        'user_issuer_id',
        'user_assigned_id',
        'observation',
        'canClientEdit',
        'isCritical',
        'isRenewable',
        'isAvailableToEdit',
        'assignment_date',
        'completion_date',
        'renewal_date',
        'activation_date',
        'contract_completion_date',
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
        'product_id',
        'previous_company_id',
        'commission',
        'potency',
        'cancellation_observation',
        'isRenovated',
        'reason_cancellation_id'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_issuer_id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_assigned_id');
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
    public function previousCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'previous_company_id');
    }

    public function reasonCancellation(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'reason_cancellation_id');
    }

    protected $casts = [
        'commission' => Money::class
    ];

    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function potency_Spanish()
    {
        if ($this->potency) {
            $result = number_format($this->potency, 4, ',', '.');
            $result = rtrim($result, '0');
            $result = rtrim($result, ',');

            return $result;
        }
    }

    public function getCommision()
    {
        return (string) $this->commission->getAmount();
    }

    public function getCreateAtFormatted()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }
}
