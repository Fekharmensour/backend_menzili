<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boost extends Model
{
    protected $fillable = [
        'listing_id',
        'member_id',
        'coins_spent',
        'status',
        'started_at',
        'expires_at',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'expired_at' => 'datetime',
            'coins_spent' => 'integer',
        ];
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at->isFuture();
    }

    public function expire(): void
    {
        $this->update([
            'status' => 'expired',
            'expired_at' => now()
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('expires_at', '>', now());
    }
}
