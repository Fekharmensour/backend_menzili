<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinPurchase extends Model
{
    use HasFactory;

    protected $table = 'coin_purchases';

    protected $fillable = [
        'member_id',
        'package_coin_id',
        'payment_method',
        'chargily_payment_id',
        'status',
        'reference_code',
        'receipt_path',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function packageCoin(): BelongsTo
    {
        return $this->belongsTo(PackageCoin::class);
    }
}
