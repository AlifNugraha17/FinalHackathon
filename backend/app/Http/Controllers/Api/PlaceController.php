<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Get list of medical & tourism places with category filter and PostGIS spatial distance calculation
     */
    public function index(Request $request)
    {
        $query = Place::with(['category', 'ferryTerminal']);

        // Filter by Category
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Proximity to Ferry Terminal
        if ($request->has('terminal') && $request->terminal !== 'all') {
            $query->whereHas('ferryTerminal', function ($q) use ($request) {
                $q->where('slug', $request->terminal);
            });
        }

        // Spatial Proximity Query (if lat and lng provided in request)
        if ($request->has(['lat', 'lng'])) {
            $lat = (float) $request->lat;
            $lng = (float) $request->lng;
            $radiusMeters = (int) $request->get('radius', 15000); // default 15km

            $query->nearLocation($lat, $lng, $radiusMeters);
        } else {
            $query->orderBy('rating', 'desc');
        }

        $places = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $places->count(),
            'data' => $places
        ]);
    }

    /**
     * Get single place detail
     */
    public function show($id)
    {
        $place = Place::with(['category', 'ferryTerminal'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $place
        ]);
    }
}
