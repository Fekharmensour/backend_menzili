<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Listing\ReviewResource;
use App\Models\Listing;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $member = Auth::user()->member;

        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 403);
        }

        // ❌ prevent duplicate
        $exists = Review::where('member_id', $member->id)
            ->where('listing_id', $listing->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => trans('api.reviews.store_already_reviewed'),
            ], 422);
        }

        // ✅ create review
        $review = Review::create([
            'member_id' => $member->id,
            'listing_id' => $listing->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        $listing->updateRating();

        return response()->json([
            'success' => true,
            'message' => trans('api.reviews.store_success'),
            'data' => new ReviewResource($review->load('member.user')),
        ], 201);
    }


    public function destroy(Listing $listing)
    {
        $member = Auth::user()->member;

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => trans('api.reviews.member_not_found'),
            ], 403);
        }

        $review = Review::where('member_id', $member->id)
            ->where('listing_id', $listing->id)
            ->first();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => trans('api.reviews.review_not_found'),
            ], 404);
        }

        $review->delete();

        $listing->updateRating();

        return response()->json([
            'success' => true,
            'message' => trans('api.reviews.delete_success'),
        ], 200);
    }
}
