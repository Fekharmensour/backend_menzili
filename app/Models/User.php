<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_image',
        'otp_code',
        'otp_expires_at',
        'is_active',
        'phone_verified_at',
        'device_token',
        'last_login_at'
    ];


    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function generateOtp(int $length = 6, int $minutes = 5): string
    {
        $otp = str_pad(rand(0, str_repeat(9, $length) - 1), $length, '0', STR_PAD_LEFT);

        $this->update([
            'otp_code'       => $otp,  // For production: consider Hash::make($otp)
            'otp_expires_at' => now()->addMinutes($minutes),
        ]);

        return $otp;
    }

    public function isValidOtp(string $otp): bool
    {
        if (!$this->otp_code || !$this->otp_expires_at) {
            return false;
        }

        $codeMatches = $this->otp_code === $otp;

        $notExpired = now()->lte($this->otp_expires_at);

        return $codeMatches && $notExpired;
    }
    public function clearOtp(): void
    {
        $this->update([
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);
    }
}
