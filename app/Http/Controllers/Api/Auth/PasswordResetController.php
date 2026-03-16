<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Member\PasswordResetService;
use App\Services\TwilioWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function __construct(protected PasswordResetService $service) {}

    /**
     * Step 1: Request OTP for Password Reset
     */
    public function requestResetOtp(Request $request ,  TwilioWhatsAppService $whatsapp)
    {
        $request->validate(['phone' => 'required|string|exists:users,phone']);

        $result = $this->service->canResetPassword($request->phone);

        if (!$result['status']) {
            return response()->json([
                'success' => false,
                'message' => __($result['message'])
            ], 403); // 403 Forbidden because they don't have a password to reset
        }

        $user = $result['user'];
        $otp = $user->generateOtp(length: 6, minutes: 10);
//        $whatsapp->sendOtp($user->phone, $otp);
        return response()->json([
            'success' => true,
            'message' => __('auth.otp_sent'),
            'data'    => ['otp_code' => $otp] // For development only
        ]);
    }

    /**
     * Step 2: Verify OTP and provide access token
     */
    public function verifyReset(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|exists:users,phone',
            'otp_code' => 'required|digits:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !$user->isValidOtp($request->otp_code)) {
            return response()->json([
                'success' => false,
                'message' => __('auth.otp_invalid_or_expired')
            ], 422);
        }

        // Create a token that ONLY has the 'reset-password' ability
        $token = $user->createToken('reset-token', ['reset-password'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => __('auth.otp_verified'),
            'data'    => ['reset_token' => $token]
        ]);
    }

    /**
     * Step 3: Set New Password (Authenticated via Token)
     */
    public function storeNewPassword(Request $request)
    {
        $request->validate(['password' => 'required|string|min:8|confirmed']);

        $user = $request->user();

        if (!$user->tokenCan('reset-password')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $user->password = $request->password;
        $user->clearOtp();$user->save();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' =>  __('profile.password_success')
        ]);
    }
}
