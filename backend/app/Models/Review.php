<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'category_slug',
        'user_name',
        'user_location',
        'user_avatar',
        'treatment_name',
        'rating',
        'cost_saved_sgd',
        'spent_sgd',
        'comment',
        'ferry_route',
        'is_verified',
        'helpful_count'
    ];

    protected $casts = [
        'rating' => 'float',
        'cost_saved_sgd' => 'float',
        'spent_sgd' => 'float',
        'is_verified' => 'boolean',
        'helpful_count' => 'integer'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
