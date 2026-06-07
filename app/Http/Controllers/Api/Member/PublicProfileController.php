<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\PaginateResource;
use App\Http\Resources\Api\Listing\ReviewResource;
use App\Http\Resources\Api\Listing\Reviewpagination;
use App\Http\Resources\Api\Member\PublicMemberResource;
use App\Models\Listing;
use App\Models\Member;
use App\Models\Review;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        $member->load('user');

        return response()->json([
            'success' => true,
            'data' => new PublicMemberResource($member),
        ]);
    }

    /**
     * Get listings of the member by pagination.
     */
    public function listings(Request $request, Member $member)
    {
        $query = $member->listings()
            ->with([
                'rentDuration',
                'type',
                'categories',
                'location.city.wilaya.country',
            ])
            ->latest();

        $listings = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => new PaginateResource($listings)
        ]);
    }

    /**
     * Get reviews for the member's listings.
     */
    public function reviews(Request $request, Member $member)
    {
        $reviewsQuery = Review::whereHas('listing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })->with(['member.user'])->latest();

        $stats = [
            'avg_rating' => (float) ($reviewsQuery->clone()->avg('rating') ?? 4.5),
            'total' => $reviewsQuery->clone()->count(),
        ];

        $paginatedReviews = $reviewsQuery->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'data' => new Reviewpagination($paginatedReviews),
        ]);
    }
}
