<?php

namespace App\Http\Controllers;

use App\Models\ChargilyPayment;
use App\Services\ChargilyService;
use Illuminate\Http\Request;

class ChargilyPayController extends Controller
{
    protected $chargily;

    public function __construct(ChargilyService $chargily)
    {
        $this->chargily = $chargily;
    }

    // 🔥 Create payment
    public function redirect()
    {
        $payment = ChargilyPayment::create([
            "user_id" => 1, // temp
            "status" => "pending",
            "currency" => "dzd",
            "amount" => 1000,
        ]);

        $checkout = $this->chargily->createCheckout($payment);

        return response()->json([
            "checkout_url" => $checkout->getUrl(),
            "payment_id" => $payment->id
        ]);
    }

    // 🔥 Webhook
    public function webhook()
    {
        \Log::info("🔥 WEBHOOK HIT");

        $webhook = $this->chargily->handleWebhook();

        if (!$webhook) {
            \Log::error("❌ Invalid webhook");
            return response()->json(["error" => "invalid"], 403);
        }

        $checkout = $webhook->getData();

        \Log::info("💳 Status: ".$checkout->getStatus());

        $payment = ChargilyPayment::find(
            $checkout->getMetadata()['payment_id']
        );

        if (!$payment) {
            \Log::error("❌ Payment not found");
            return response()->json(["error" => "not found"], 404);
        }

        // prevent duplicate
        if ($payment->status === "paid") {
            \Log::info("already processed");
            return response()->json(["message" => "already processed"]);
        }

        if ($checkout->getStatus() === "paid") {
            \Log::info("the status is updated to paid");
            $payment->update(["status" => "paid"]);
        } else {
            \Log::info("the status is updated to failed");
            $payment->update(["status" => "failed"]);
        }

        \Log::info("the payment status is updated to ".$payment->status . " successfully !");

        return response()->json([
            "status" => $payment->status
        ]);
    }

    public function success(Request $request)
    {
        return response()->json([
            "message" => "success",
            "checkout_id" => $request->checkout_id
        ]);
    }

    public function failed(Request $request)
    {
        return response()->json([
            "message" => "false",
            "checkout_id" => $request->checkout_id
        ]);
    }
}
