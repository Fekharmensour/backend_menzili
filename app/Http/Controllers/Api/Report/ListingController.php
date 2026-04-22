<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Report;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\HeaderParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Report Listings')]
#[HeaderParameter('Auth')]
class ListingController extends Controller
{
    public function reportListing(Request $request, Listing $listing)
    {
        $request->validate([
            'report' => 'required|string',
        ]);

        $member = Auth::user()->member;
        $exists = Report::where('member_id', $member->id)
            ->where('reference_id', $listing->id)
            ->where('reference_type', Listing::class)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => trans('api.report.already_reported'),
            ], 422);
        }

        Report::create([
            'member_id' => $member->id,
            'report' => $request->report,
            'reference_id' => $listing->id,
            'reference_type' => Listing::class,
        ]);

        return response()->json([
            'success' => true,
            'message' => trans('api.report.sent_success'),
        ]);
    }
}
