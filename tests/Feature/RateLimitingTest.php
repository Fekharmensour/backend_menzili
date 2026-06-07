<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    /**
     * Test OTP request is throttled.
     */
    public function test_otp_request_is_throttled(): void
    {
        $payload = ['phone' => '0555555555'];

        // We can't easily avoid DB if the controller hits it, 
        // but we can measure how many times it was called or just look for 429.
        
        // Let's use a route that is definitely throttled.
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/auth/login', $payload);
        }

        $this->postJson('/api/auth/login', $payload)
            ->assertStatus(429);
    }

    /**
     * Test global API rate limiting for guests.
     */
    public function test_global_api_is_throttled_for_guests(): void
    {
        // 30 is the limit for guests
        for ($i = 0; $i < 30; $i++) {
            $this->getJson('/api/pay'); // This route is simple
        }

        $this->getJson('/api/pay')
            ->assertStatus(429);
    }
}
