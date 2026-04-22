<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\HeaderParameter;
use Illuminate\Http\Request;

#[Group('Admin/Reports')]
#[HeaderParameter('Auth')]
class ReportController extends Controller
{
    public function listingReports()
    {
        $reports = Report::where('reference_type', \App\Models\Listing::class)
            ->with(['member.user', 'reference'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'type' => 'listing_reports',
            'data' => $reports
        ]);


    }

    public function memberReports()
    {
        $reports = Report::where('reference_type', \App\Models\Member::class)
            ->with(['member.user', 'reference'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'type' => 'member_reports',
            'data' => $reports
        ]);
    }

    public function allReports()
    {
        $reports = Report::with(['member.user', 'reference'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

}
