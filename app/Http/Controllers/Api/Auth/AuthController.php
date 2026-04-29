<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Profile\MemberProfileResource;
use App\Http\Resources\Api\Profile\UserResource;
use App\Http\Responses\ApiResponseTrait;
use App\Models\FcmToken;
use App\Models\User;
use App\Services\TwilioWhatsAppService;
use App\Traits\HandlesDeviceTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;
    use HandlesDeviceTokens;




    public function requestOtp(Request $request , TwilioWhatsAppService $whatsapp)
    {
        $request->validate([
            'phone' => 'required|string|min:9|max:15',
        ]);

        try{
            $phone = $request->phone;
            $user = User::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => null, // will be filled later
                'is_active' => true,
            ]
        );

        $otp = $user->generateOtp(minutes: 5, length: 6);
//        $whatsapp->sendOtp($phone, $otp);
        return response()->json([
            'success' => true,
            'message' => __('auth.otp_sent'),
            'status'  => 200,
            'data' => [
                'otp_code' => $otp,
            ],
        ]);
        }catch(\Exception $e){
            return $this->apiError('auth.otp_failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string',
            'otp_code' => 'required|digits:6',
            'fcm_token' => 'nullable|string',
            'device_type' => 'nullable|string|max:50',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('auth.user_not_found'),
                'status'  => 404,
            ], 404);
        }

        if (!$user->isValidOtp($request->otp_code)) {
            $user->clearOtp();

            return response()->json([
                'success' => false,
                'message' => __('auth.otp_invalid_or_expired'),
                'status'  => 422,

            ], 422);
        }

        $user->clearOtp();
        $user->update([
            'phone_verified_at' => now(),
            'last_login_at'     => now(),
        ]);

        $token = $this->createDeviceToken($user, $request);
        $this->upsertFcmToken($user->id, $request->input('fcm_token'), $request->input('device_type'));



        return response()->json([
            'success' => true,
            'message' => __('auth.otp_verified'),
            'status'  => 200,
            'data'    => [
                'token'   => $token,
                'fill_name' => $user->name? true : false,
            ],
        ]);
    }


    public function completeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        $user = Auth::user();

        if (blank($user->name)) {
            $user->update(['name' => $request->name]);
        }

        // Force type hint to Member
        /** @var \App\Models\Member $member */
        $member = $user->member ?? $user->member()->create();

        // Deposit only if balance is 0
        if ($member->balanceInt === 0) {
            $member->deposit(50, [
                'reason' => 'initial_bonus',
                'name' => 'Coins Wallet',
                'slug' => 'coins',
                'decimal_places' => 0
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('auth.profile_completed'),
            'status'  => 200,
            'data'    => ['user' => new MemberProfileResource($user)],
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => __('auth.logout'),
            'status'  => 200,
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string', // Can be email or phone
            'password' => 'required|string',
            'fcm_token' => 'nullable|string',
            'device_type' => 'nullable|string|max:50',
        ]);

        // Determine if input is email or phone
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($loginField, $request->login)->first();

        // Verify User and Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('auth.failed'),
                'status'  => 401,
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => __('auth.account_disabled'),
                'status'  => 403,
            ], 403);
        }

        $user->update(['last_login_at' => now()]);
        $token = $this->createDeviceToken($user, $request);
        if ( $request->input('fcm_token')) $this->upsertFcmToken($user->id, $request->input('fcm_token'), $request->input('device_type'));

        return response()->json([
            'success' => true,
            'message' => __('auth.login_success'),
            'status'  => 200,
            'data'    => [
                'token'     => $token,
                'user'      => new MemberProfileResource($user),
                'fill_name' => !blank($user->name),
            ],
        ]);
    }

    public function storeFcmTokenForCurrentUser(Request $request)
    {
        $validated = $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $deviceType =  $request->header('X-Device-Name')
            ?? $request->userAgent()
            ?? 'unknown';

        $this->upsertFcmToken((int) Auth::id(), $validated['fcm_token'], $deviceType);

        return response()->json([
            'success' => true,
            'message' => trans('auth.fcm_token_updated'),
            'status' => 200,
        ]);
    }

    private function upsertFcmToken(int $userId, ?string $fcmToken, ?string $deviceType = null): void
    {
        if (!$fcmToken) {
            return;
        }

        FcmToken::query()->updateOrCreate(
            ['token' => $fcmToken],
            [
                'user_id' => $userId,
                'device_type' => $deviceType,
            ]
        );
    }
}
