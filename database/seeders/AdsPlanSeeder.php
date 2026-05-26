<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdsPlan;

class AdsPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'coins' => 100,
                'duration_days' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Standard',
                'coins' => 350,
                'duration_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'coins' => 1000,
                'duration_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            AdsPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
