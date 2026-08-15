<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'user_name',
        'user_email',
        'user_phone',
        'booking_date',
        'booking_time',
        'pickup_required',
        'pickup_terminal_id',
        'status',
        'notes'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function pickupTerminal()
    {
        return $this->belongsTo(FerryTerminal::class, 'pickup_terminal_id');
    }
}
