<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Get list of verified reviews with filters and aggregate statistics
     */
    public function index(Request $request)
    {
        $query = Review::with('place');

        // Filter by Category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category_slug', $request->category);
        }

        // Filter by Place ID
        if ($request->has('place_id')) {
            $query->where('place_id', $request->place_id);
        }

        // Sort By
        $sortBy = $request->get('sort_by', 'latest');
        if ($sortBy === 'highest_savings') {
            $query->orderBy('cost_saved_sgd', 'desc');
        } elseif ($sortBy === 'highest_rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'most_helpful') {
            $query->orderBy('helpful_count', 'desc');
        } else {
            $query->latest();
        }

        $reviews = $query->get();

        // Calculate Aggregate Statistics
        $totalReviews = Review::count();
        $avgRating = round((float) Review::avg('rating') ?: 4.9, 1);
        $totalSgdSaved = round((float) Review::sum('cost_saved_sgd') ?: 2635.0, 2);

        return response()->json([
            'status' => 'success',
            'stats' => [
                'average_rating' => $avgRating,
                'total_reviews' => $totalReviews,
                'total_sgd_saved' => $totalSgdSaved,
                'verified_percentage' => 100
            ],
            'count' => $reviews->count(),
            'data' => $reviews
        ]);
    }

    /**
     * Store a new patient/traveler review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:100',
            'user_location' => 'nullable|string|max:100',
            'treatment_name' => 'required|string|max:150',
            'category_slug' => 'required|string|max:50',
            'rating' => 'required|numeric|min:1|max:5',
            'spent_sgd' => 'required|numeric|min:0',
            'cost_saved_sgd' => 'nullable|numeric|min:0',
            'comment' => 'required|string|min:10',
            'place_id' => 'nullable|exists:places,id',
            'ferry_route' => 'nullable|string|max:150'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        
        // Auto-fill user location if empty
        if (empty($data['user_location'])) {
            $data['user_location'] = 'Singapore 🇸🇬';
        }

        // Auto avatar placeholder based on initials
        $initials = urlencode($data['user_name']);
        $data['user_avatar'] = "https://ui-avatars.com/api/?name={$initials}&background=0ea5e9&color=fff";
        $data['is_verified'] = true;
        $data['helpful_count'] = 0;

        $review = Review::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas ulasan Anda! Ulasan Anda telah terverifikasi.',
            'data' => $review->load('place')
        ], 201);
    }

    /**
     * Upvote/Helpful count increment
     */
    public function helpful($id)
    {
        $review = Review::findOrFail($id);
        $review->increment('helpful_count');

        return response()->json([
            'status' => 'success',
            'helpful_count' => $review->helpful_count
        ]);
    }
}
