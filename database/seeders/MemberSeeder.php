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
        $members = [
            [
                'name'      => 'mensourfk',
                'phone'     => '+213665001345',
                'email'     => 'mensourfk@gmail.com',
                'password'  => '12345678',
                'is_admin'  => false,
            ],
            [
                'name'      => 'yacineZt',
                'phone'     => '+213558769547',
                'email'     => 'yacinezt@gmail.com',
                'password'  => '12345678',
                'is_admin'  => false,
            ],
            [
                'name'      => 'youcef_G',
                'phone'     => '+213776896637',
                'email'     => 'youcef.g@gmail.com',
                'password'  => '12345678',
                'is_admin'  => false,
            ],
            [
                'name'      => 'menzili',
                'phone'     => '+213555555555',
                'email'     => 'menzili@gmail.com',
                'password'  => 'menzili',           // different password
                'is_admin'  => true,
            ],
            [
                'name'      => 'mensour Fekhar',
                'phone'     => '+213562695982',
                'email'     => 'mensourfekhar@gmail.com',
                'password'  => '12345678',
                'is_admin'  => false,
            ],
        ];

        foreach ($members as $data) {
            // Create or update User
            $user = User::firstOrCreate(
                ['phone' => $data['phone']],
                [
                    'name'              => $data['name'],
                    'email'             => $data['email'],
                    'password'          => Hash::make($data['password']),
                    'is_active'         => 1,
                    'phone_verified_at' => now(),
                    'is_admin'          => $data['is_admin'] ?? false,   // if your User model has is_admin column
                ]
            );

            // Create or update Member
            Member::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'member_verified_at' => now(),
                ]
            );
        }
    }
}
