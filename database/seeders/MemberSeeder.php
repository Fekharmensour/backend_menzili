<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Check if user already exists
        $user = User::firstOrCreate(
            ['phone' => '+213562695982'],
            [
                'name' => 'mensourfk',
                'email' => 'mensourfekhar@gmail.com',
                'password' => Hash::make('12345678'),
                'is_active' => 1,
                'phone_verified_at' => now(),

            ]
        );

        // Create member if not exists
        Member::firstOrCreate(
            ['user_id' => $user->id],
            [
                'member_verified_at'=>now()
            ]
        );
    }
}
