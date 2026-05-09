<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageCoin extends Model
{
    protected $table = 'package_coins';

    protected $fillable = [
        'coins',
        'price',
        'date_end_offer',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_end_offer' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function coinPurchases(): HasMany
    {
        return $this->hasMany(CoinPurchase::class);
    }
}
