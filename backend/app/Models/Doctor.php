<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    protected $fillable = [
        'place_id',
        'name',
        'specialization',
        'degree',
        'languages_spoken',
        'consultation_fee_sgd',
        'consultation_fee_idr',
        'schedule_days',
        'rating',
        'avatar_url'
    ];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
