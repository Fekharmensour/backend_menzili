<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesDeviceTokens
{
    /**
     * Generate a consistent token name for the same device
     * based on User-Agent
     */
    protected function getDeviceTokenName(Request $request): string
    {
        $userAgent = $request->header('User-Agent', 'unknown-device');

        // Create a stable short hash from User-Agent
        return 'device-' . substr(md5($userAgent), 0, 16);
    }
    protected function createDeviceToken($user, Request $request)
    {
        $tokenName = $this->getDeviceTokenName($request);

        // Delete any existing token for this device
        $user->tokens()->where('name', $tokenName)->delete();

        // Create new token
        return $user->createToken($tokenName)->plainTextToken;
    }
}
