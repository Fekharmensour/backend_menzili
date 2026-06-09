<?php

namespace App\Services;

use App\Models\CoinPurchase;
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

    public function createCheckout($payment, $successUrl = null, $failureUrl = null)
    {
        $locale = app()->getLocale();
        return $this->client()->checkouts()->create([
            "metadata" => [
                "payment_id" => $payment->id,
            ],
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "description" => "Payment ID={$payment->id}",

            // ✅ Use provided URLs or fallback to backend routes
            "success_url" => $successUrl ?? config('app.url')."/{$locale}/success",
            "failure_url" => $failureUrl ?? config('app.url')."/{$locale}/failed",
            "webhook_endpoint" => config('app.url')."/api/webhook",
        ]);
    }

    public function handleWebhook()
    {
        return $this->client()->webhook()->get();
    }
    public function webhook()
    {
        \Log::info("🔥 WEBHOOK HIT");

        $webhook = $this->handleWebhook();
        if (!$webhook) {
            return response()->json(["error" => "Invalid"], 403);
        }

        $checkout = $webhook->getData();
        $chargilyPayment = \App\Models\ChargilyPayment::find(
            $checkout->getMetadata()['payment_id']
        );

        if (!$chargilyPayment || $chargilyPayment->status === "paid") {
            return response()->json(["message" => "Already processed"]);
        }

        if ($checkout->getStatus() === "paid") {
            $chargilyPayment->update(["status" => "paid"]);

            // 🔑 CREDIT COINS TO MEMBER
            $this->creditCoinsFromPayment($chargilyPayment);
        } else {
            $chargilyPayment->update(["status" => "failed"]);
        }

        return response()->json(["status" => $chargilyPayment->status]);
    }

    public function creditCoinsFromPayment($chargilyPayment)
    {
        // Find associated coin purchase
        $coinPurchase = CoinPurchase::where(
            'chargily_payment_id',
            $chargilyPayment->id
        )->first();
        if (!$coinPurchase) {
            \Log::error("❌ CoinPurchase NOT FOUND");
            return;
        }

        $member = $coinPurchase->member;
        $package = $coinPurchase->packageCoin;

        // Credit coins to wallet
        $member->deposit(
            $package->coins,
            [
                'reason' => 'coin_purchase',
                'purchase_id' => $coinPurchase->id,
                'payment_method' => 'chargily',
                'amount_paid' => $chargilyPayment->amount,
            ]
        );

        // Update purchase status
        $coinPurchase->update(['status' => 'completed']);

        \Log::info("✅ Coins credited: {$package->coins} coins to member {$member->id}");
    }
}

