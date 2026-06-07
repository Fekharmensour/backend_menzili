<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Member\ActivityResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberActivityController extends Controller
{
    /**
     * Get recent activities for the authenticated member.
     */
    public function index(Request $request)
    {
        $member = Auth::user()->member;
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => __('api.reviews.member_not_found'),
            ], 404);
        }

        $transactions = $member->transactions()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return ActivityResource::collection($transactions);
    }
}
