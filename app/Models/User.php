<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
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
        'is_admin',
        'phone_verified_at',
        'device_token',
        'last_login_at',
        'password'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return null;
        }

        $path = str_replace('/storage/', '', $this->profile_image);

        return asset('storage/' . $path);
    }

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
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function generateOtp(int $length = 6, int $minutes = 5): string
    {
        // For 6 digits: generates a number between 100000 and 999999
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;

        $otp = (string) random_int($min, $max);

        $this->update([
            'otp_code'       => $otp,
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





//    =====================[ Relations ]==============================

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }
}
