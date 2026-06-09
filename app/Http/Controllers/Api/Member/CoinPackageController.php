<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CoinPackageResource;
use App\Models\CoinPurchase;
use App\Models\PackageCoin;
use App\Services\ChargilyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoinPackageController extends Controller
{
    public function __construct(protected ChargilyService $chargily)
    {
    }

    public function index()
    {
        $packages = PackageCoin::where('is_active', true)
            ->orderBy('coins', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => __('api.coin_package.index.success'),
            'data' => CoinPackageResource::collection($packages),
        ]);
    }

    public function buy(Request $request, PackageCoin $package)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,baridimob,chargily',
            'success_url' => 'nullable|string',
            'failure_url' => 'nullable|string',
        ]);

        $member = Auth::user()->member;

        if (!$member || !$package->is_active) {
            return response()->json([
                'success' => false,
                'message' => trans('api.coin_package.buy.unauthorized'),
            ], 400);
        }

        $purchase = CoinPurchase::create([
            'member_id' => $member->id,
            'package_coin_id' => $package->id,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        // Handle payment method
        if ($validated['payment_method'] === 'chargily') {
            return $this->handleChargilyCheckout(
                $purchase,
                $package,
                $validated['success_url'] ?? null,
                $validated['failure_url'] ?? null
            );
        } elseif ($validated['payment_method'] === 'baridimob') {
            return $this->handleBaridimobInitiate($purchase, $package);
        } elseif ($validated['payment_method'] === 'cash') {
            return $this->handleCashInitiate($purchase, $package);
        }
    }

    private function handleChargilyCheckout(CoinPurchase $purchase, PackageCoin $package, $successUrl = null, $failureUrl = null)
    {
        // Append purchase_id to successUrl for frontend verification
        if ($successUrl) {
            $separator = (str_contains($successUrl, '?')) ? '&' : '?';
            $successUrl .= $separator . "purchase_id=" . $purchase->id;
        }

        try {
            // Create ChargilyPayment record
            $chargilyPayment = \App\Models\ChargilyPayment::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'currency' => 'dzd',
                'amount' => $package->price,
            ]);

            // Link to coin purchase
            $purchase->update(['chargily_payment_id' => $chargilyPayment->id]);

            // Create Chargily checkout
            $checkout = $this->chargily->createCheckout($chargilyPayment, $successUrl, $failureUrl);

            return response()->json([
                'success' => true,
                'message' => trans('api.coin_package.buy.chargily_checkout_success'),
                'data' => [
                    'purchase_id' => $purchase->id,
                    'checkout_url' => $checkout->getUrl(),
                    'amount' => $package->price,
                    'coins' => $package->coins,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function handleBaridimobInitiate(CoinPurchase $purchase, PackageCoin $package)
    {
        return response()->json([
            'success' => true,
            'message' => 'Please upload your Baridimob receipt',
            'data' => [
                'purchase_id' => $purchase->id,
                'amount' => $package->price,
                'coins' => $package->coins,
                'note' => 'Upload a PDF receipt to proceed',
            ],
        ]);
    }

    /**
     * Baridimob Payment: Upload receipt
     * POST /api/coin-packages/upload-receipt
     * Form: { "purchase_id": 1, "receipt": file }
     */
    public function uploadReceipt(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:coin_purchases,id',
            'receipt' => 'required|file|mimes:pdf|max:5120',
        ]);

        $purchase = CoinPurchase::find($validated['purchase_id']);
        $member = Auth::user()->member;

        if ($purchase->member_id !== $member->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Store receipt file
        $filePath = $request->file('receipt')->store('receipts/baridimob', 'public');

        // Update purchase with receipt
        $purchase->update([
            'receipt_path' => $filePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Receipt uploaded. Awaiting admin approval',
            'data' => [
                'purchase_id' => $purchase->id,
                'status' => $purchase->status,
            ],
        ]);
    }

    /**
     * Cash Payment: Generate reference code
     */
    private function handleCashInitiate(CoinPurchase $purchase, PackageCoin $package)
    {
        $referenceCode = 'CASH-' . str_pad($purchase->id, 6, '0', STR_PAD_LEFT);

        $purchase->update([
            'reference_code' => $referenceCode,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Show this code to agent',
            'data' => [
                'purchase_id' => $purchase->id,
                'reference_code' => $referenceCode,
                'amount' => $package->price,
                'coins' => $package->coins,
                'note' => 'Give this code to the agent to confirm payment',
            ],
        ]);
    }

    /**
     * Check purchase status
     * GET /api/coin-purchases/{id}/status
     */
    public function status(CoinPurchase $purchase)
    {
        $member = Auth::user()->member;

        if ($purchase->member_id !== $member->id) {
            return response()->json(['success' => false], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $purchase->id,
                'status' => $purchase->status,
                'coins' => $purchase->packageCoin->coins,
                'package_name' => $purchase->packageCoin->name,
                'amount' => $purchase->packageCoin->price,
                'currency' => 'DZD',
                'payment_method' => $purchase->payment_method,
                'created_at' => $purchase->created_at->toDateTimeString(),
            ],
        ]);
    }
}
