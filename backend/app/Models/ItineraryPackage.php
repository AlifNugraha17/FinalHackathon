<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryPackage extends Model
{
    protected $fillable = [
        'title',
        'theme',
        'duration_days',
        'estimated_cost_sgd',
        'estimated_savings_sgd',
        'highlights',
        'steps_json',
        'image_url'
    ];

    protected $casts = [
        'steps_json' => 'array'
    ];
}
