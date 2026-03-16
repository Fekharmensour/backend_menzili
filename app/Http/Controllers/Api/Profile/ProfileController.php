<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateImageRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\VerifyAgentRequest;
use App\Http\Requests\Profile\VerifyMemberRequest;
use App\Http\Resources\Api\Profile\MemberProfileResource;
use App\Services\Member\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $service) {}

    public function show()
    {
        return response()->json([
            'success' => true,
            'data' => new MemberProfileResource(Auth::user()->load('member')),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $this->service->updateBasicInfo($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => __('profile.update_success'),
            'data' => new MemberProfileResource($user->load('member')),
        ]);
    }

    public function updateImage(UpdateImageRequest $request)
    {
        $user = Auth::user();

        // Using validated data from the Form Request
        $validated = $request->validated();

        $this->service->updateProfileImage($user, $validated['profile_image']);

        return response()->json([
            'success' => true,
            'message' => __('profile.image_success'),
            'data'    => new MemberProfileResource($user->load('member')),
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('profile.password_current_invalid')
            ], 422);
        }

        $user->password = $validated['password'];
         $user->save();

        return response()->json([
            'success' => true,
            'message' => __('profile.password_success'),
            'data' => new MemberProfileResource($user->load('member')),
        ]);
    }

    public function verifyMember(VerifyMemberRequest $request)
    {
        $this->service->submitMemberVerification(Auth::user(), $request->validated());

        return response()->json([
            'success' => true,
            'message' => __('profile.verify_member_success'),
            'data' => new MemberProfileResource(Auth::user()->load('member')),
        ], 201);
    }

    public function verifyAgent(VerifyAgentRequest $request)
    {
        $status = $this->service->submitAgentVerification(Auth::user(), $request->file('document'));

        if (!$status) {
            return response()->json([
                'success' => false,
                'message' => __('profile.agent_verify_requirement_failed')
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => __('profile.verify_agent_success'),
            'data' => new MemberProfileResource(Auth::user()->load('member')),
        ], 201);
    }
}
