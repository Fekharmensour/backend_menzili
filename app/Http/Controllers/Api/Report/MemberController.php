<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function reportMember(Request $request, Member $target)
    {
        $request->validate([
            'report' => 'required|string',
        ]);

        $member = Auth::user()->member;
        $exists = Report::where('member_id', $member->id)
            ->where('reference_id', $target->id)
            ->where('reference_type', Member::class)
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
            'reference_id' => $target->id,
            'reference_type' => Member::class,
        ]);

        return response()->json([
            'success' => true,
            'message' => trans('api.report.sent_success'),
        ]);
    }
}
