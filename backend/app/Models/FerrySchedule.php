<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FerrySchedule extends Model
{
    protected $fillable = [
        'operator_name',
        'origin_terminal_id',
        'destination_terminal_id',
        'departure_time',
        'arrival_time',
        'duration_minutes',
        'price_sgd',
        'price_idr',
        'status',
        'days_active'
    ];

    public function originTerminal(): BelongsTo
    {
        return $this->belongsTo(FerryTerminal::class, 'origin_terminal_id');
    }

    public function destinationTerminal(): BelongsTo
    {
        return $this->belongsTo(FerryTerminal::class, 'destination_terminal_id');
    }
}
