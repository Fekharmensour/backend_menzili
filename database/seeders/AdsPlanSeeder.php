<?php

namespace Database\Seeders;

use App\Models\AdsPlan;
use Illuminate\Database\Seeder;

class AdsPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                'duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'coins' => 1000,
                'duration_days' => 90,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            AdsPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
