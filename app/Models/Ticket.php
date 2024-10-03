<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'user_issuer_id',
        'user_assigned_id',
        'formality_id',
        'ticket_type_id',
        'status_id',
        'ticket_title',
        'ticket_description',
        'resolution_date',
        'isResolved',
        'assignment_date'
    ];

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_issuer_id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_assigned_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function formality(): BelongsTo
    {
        return $this->belongsTo(Formality::class, 'formality_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ComponentOption::class, 'ticket_type_id');
    }

    public function comments(): MorphToMany
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

}
