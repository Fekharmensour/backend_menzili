<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinPurchase;
use Illuminate\Http\Request;

class CoinPurchaseController extends Controller
{
    /**
     * List coin purchases, optionally filtering by status.
     * GET /api/admin/coin-purchases
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        
        $purchases = CoinPurchase::with(['member.user', 'packageCoin'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $purchases
        ]);
    }

    /**
     * Approve a Baridimob coin purchase and credit the coins to the user.
     * POST /api/admin/coin-purchases/{purchase}/approve
     */
    public function approve(CoinPurchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Purchase is not in a pending state.',
            ], 400);
        }

        $member = $purchase->member;
        $package = $purchase->packageCoin;

        // Credit coins to wallet
        $member->deposit(
            $package->coins,
            [
                'reason' => 'coin_purchase_' . $purchase->payment_method,
                'purchase_id' => $purchase->id,
                'payment_method' => $purchase->payment_method,
            ]
        );

        // Update purchase status
        $purchase->update([
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase approved and coins credited successfully.',
            'data' => [
                'purchase_id' => $purchase->id,
                'status' => $purchase->status,
                'credited_coins' => $package->coins,
            ]
        ]);
    }
}
