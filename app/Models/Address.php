<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    public $timestamps = false;

    protected $fillable = [
        'location_id',
        'street_type_id',
        'housing_type_id',
        'full_address',
        'street_name',
        'street_number',
        'zip_code',
        'block',
        'block_staircase',
        'floor',
        'door',
    ];


    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function streetType(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'street_type_id');
    }

    public function housingType(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'housing_type_id');
    }

    public function fullAddress()
    {
        $streetType = $this->streetType ? $this->streetType->name : '';

        return $streetType . ' ' . $this->street_name . ' ' . $this->street_number . ' ' . $this->block . ' ' . $this->block_staircase . ' ' . $this->floor . ' ' . $this->door;
    }
}
