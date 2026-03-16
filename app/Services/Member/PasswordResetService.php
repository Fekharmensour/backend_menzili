<?php

namespace App\Services\Member;



use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetService
{
    public function generateResetOtp(string $phone): ?User
    {
        $user = User::where('phone', $phone)->first();

        if ($user) {
            $user->generateOtp(length: 6, minutes: 10);
        }

        return $user;
    }
    public function canResetPassword(string $phone): array
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return ['status' => false, 'message' => 'auth.user_not_found'];
        }


        return ['status' => true, 'user' => $user];
    }

    public function resetPassword(User $user, string $password): bool
    {
        $user->password = Hash::make($password);
        $user->clearOtp();
        return $user->save();
    }
}
