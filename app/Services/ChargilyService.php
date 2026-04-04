<?php

namespace App\Services;

use Chargily\ChargilyPay\ChargilyPay;
use Chargily\ChargilyPay\Auth\Credentials;

class ChargilyService
{
    private function client()
    {
        return new ChargilyPay(new Credentials([
            "mode" => config('chargily.mode'),
            "public" => config('chargily.public'),
            "secret" => config('chargily.secret'),
        ]));
    }

    public function createCheckout($payment)
    {
        $locale = app()->getLocale();
        return $this->client()->checkouts()->create([
            "metadata" => [
                "payment_id" => $payment->id,
            ],
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "description" => "Payment ID={$payment->id}",

            // ✅ IMPORTANT
            "success_url" => config('app.url')."/{$locale}/success",
            "failure_url" => config('app.url')."/{$locale}/failed",
            "webhook_endpoint" => config('app.url')."/api/webhook",
        ]);
    }

    public function handleWebhook()
    {
        return $this->client()->webhook()->get();
    }
}
