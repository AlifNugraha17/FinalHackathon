<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\EnhancedTourismController;

/*
|--------------------------------------------------------------------------
| API Routes for SG ⇄ Batam Cross-Border Tourism Hub
|--------------------------------------------------------------------------
*/

Route::get('/places', [PlaceController::class, 'index']);
Route::get('/places/{id}', [PlaceController::class, 'show']);
Route::post('/bookings', [BookingController::class, 'store']);

// Enhanced Tourism API Endpoints
Route::get('/ferry-schedules', [EnhancedTourismController::class, 'ferrySchedules']);
Route::get('/fair-prices', [EnhancedTourismController::class, 'fairPrices']);
Route::get('/doctors', [EnhancedTourismController::class, 'doctors']);
Route::get('/itinerary-packages', [EnhancedTourismController::class, 'itineraryPackages']);

// Verified Reviews & Ratings Endpoints
Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::post('/reviews/{id}/helpful', [ReviewController::class, 'helpful']);

// Live Exchange Rate API Endpoint (SGD ⇄ IDR)
Route::get('/exchange-rate', function () {
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(3)->get('https://open.er-api.com/v6/latest/SGD');
        if ($response->successful()) {
            $data = $response->json();
            $rate = $data['rates']['IDR'] ?? 13920.00;
            return response()->json([
                'base' => 'SGD',
                'target' => 'IDR',
                'rate' => (float)$rate,
                'provider' => 'Open Exchange Rates API',
                'last_updated' => now()->toIso8601String()
            ]);
        }
    } catch (\Throwable $e) {
        // Fallback
    }

    return response()->json([
        'base' => 'SGD',
        'target' => 'IDR',
        'rate' => 13920.00,
        'provider' => 'Default 2026 Rate',
        'last_updated' => now()->toIso8601String()
    ]);
});

