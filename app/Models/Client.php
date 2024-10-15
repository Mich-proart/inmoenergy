<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'disabled_at',
        'country_id'
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

    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, 'client_address')
            ->using(ClientAddress::class)
            ->withPivot(['iscorrespondence']);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function telephone()
    {
        $code = $this->country ? '+' . $this->country->phone_code : '';
        return $code . ' ' . $this->phone;
    }

}
