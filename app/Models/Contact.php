<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'job_title',
        'business_card_front',
        'business_card_back',
        'event_name',
        'date_of_creation',
        'gps_coordinates',
        'notes',
    ];

    protected $casts = [
        'date_of_creation' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
