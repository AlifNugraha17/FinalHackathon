<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairPriceBenchmark extends Model
{
    protected $fillable = [
        'category',
        'item_name',
        'fair_price_min_idr',
        'fair_price_max_idr',
        'price_sgd_benchmark',
        'unit',
        'warning_threshold_idr',
        'notes'
    ];
}
