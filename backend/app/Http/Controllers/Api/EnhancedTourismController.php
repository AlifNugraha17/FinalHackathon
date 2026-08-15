<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\FerrySchedule;
use App\Models\FairPriceBenchmark;
use App\Models\Doctor;
use App\Models\ItineraryPackage;

class EnhancedTourismController extends Controller
{
    public function ferrySchedules(Request $request): JsonResponse
    {
        $query = FerrySchedule::with(['originTerminal', 'destinationTerminal']);

        if ($request->has('origin')) {
            $query->whereHas('originTerminal', function ($q) use ($request) {
                $q->where('slug', $request->origin);
            });
        }

        if ($request->has('destination')) {
            $query->whereHas('destinationTerminal', function ($q) use ($request) {
                $q->where('slug', $request->destination);
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->orderBy('departure_time')->get()
        ]);
    }

    public function fairPrices(Request $request): JsonResponse
    {
        $query = FairPriceBenchmark::query();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%')
                  ->orWhere('notes', 'like', '%' . $search . '%');
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    public function doctors(Request $request): JsonResponse
    {
        $query = Doctor::with('place');

        if ($request->has('specialization')) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    public function itineraryPackages(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => ItineraryPackage::all()
        ]);
    }
}
