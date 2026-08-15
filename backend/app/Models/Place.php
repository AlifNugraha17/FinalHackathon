<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'ferry_terminal_id',
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'price_sgd',
        'savings_percent',
        'rating',
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ferryTerminal()
    {
        return $this->belongsTo(FerryTerminal::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope query to find places near a given latitude/longitude using PostgreSQL PostGIS (with standard SQL Haversine fallback)
     */
    public function scopeNearLocation($query, $lat, $lng, $distanceInMeters = 10000)
    {
        $hasPostgisLocation = false;
        if (DB::getDriverName() === 'pgsql') {
            try {
                $hasPostgisLocation = Schema::hasColumn('places', 'location');
            } catch (\Throwable $e) {
                $hasPostgisLocation = false;
            }
        }

        if ($hasPostgisLocation) {
            return $query->select('*')
                ->selectRaw(
                    "ST_DistanceSphere(location, ST_MakePoint(?, ?)) as distance_meters",
                    [$lng, $lat]
                )
                ->whereRaw(
                    "ST_DWithin(location::geography, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, ?)",
                    [$lng, $lat, $distanceInMeters]
                )
                ->orderBy('distance_meters', 'asc');
        }

        // Standard Haversine distance formula (in meters) using latitude & longitude
        $haversine = "(6371000 * acos(least(1.0, greatest(-1.0, cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))))";

        return $query->select('*')
            ->selectRaw("{$haversine} as distance_meters", [$lat, $lng, $lat])
            ->whereRaw("{$haversine} <= ?", [$lat, $lng, $lat, $distanceInMeters])
            ->orderBy('distance_meters', 'asc');
    }
}
