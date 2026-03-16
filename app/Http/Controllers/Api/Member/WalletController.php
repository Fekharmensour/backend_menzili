<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreRequest;
use App\Http\Resources\Api\Wallet\MyWalletResource;
use App\Http\Resources\Api\Wallet\TransactionResource;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function show()
    {
        $member = Auth::user()->member; // assume user hasOne Member

//        return new MyWalletResource($member->wallet);
        return response()->json([
            "success" => true,
            "message" => __('api.wallet.show.success'),
            "data" => new MyWalletResource($member->wallet),
        ]);
    }

    // List wallet transactions
    public function transactions()
    {
        $member = Auth::user()->member;

        $transactions = $member->transactions()->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => __('api.wallet.transactions.success'),
            'data' => TransactionResource::collection($transactions),
        ]);
    }

    // Deposit coins (add coins)
    public function addCoins(StoreRequest $request)
    {
        $validated = $request->validated();

        $member = Auth::user()->member;

        $member->deposit(
            $validated['amount'],
            [
                'reason' => $validated['reason'],
                'payment_method' => $validated['payment_method'],
                'payment_id' => $validated['payment_id'],
                'listing_id' => $validated['listing_id'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => __('api.wallet.add_coins.success'),
            'data' => [
                new MyWalletResource($member->wallet),
                'transaction' => new TransactionResource($member->transactions()->latest()->first()),
            ],

        ]);
    }
}
