<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isWorker',
        'first_last_name',
        'second_last_name',
        'document_number',
        'document_type_id',
        'phone',
        'address_id',
        'adviser_assigned_id',
        'responsible_id',
        'incentive_type_id',
        'office_id',
        'disabled_at',
        'isActive'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function adviserAssigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_assigned_id');
    }


    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }


    public function documentType(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'document_type_id');
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return 'Aqui va Role';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function incentive(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'incentive_type_id');
    }


    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
