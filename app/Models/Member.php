<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model implements Wallet
{
    use HasWallet;
    public const STATUS_UNSUBMITTED = 'unsubmitted';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'card_id_front_path',
        'card_id_back_path',
        'document_path',
        'member_verified_at',
        'agent_verified_at',
        'identity_status',
        'identity_rejection_reason',
        'agent_status',
        'agent_rejection_reason',
    ];


    protected function casts(): array
    {
        return [
            'member_verified_at' => 'datetime',
            'agent_verified_at' => 'datetime',
        ];
    }



    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function listings():HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reportsReceived()
    {
        return $this->morphMany(Report::class, 'reference');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function coinPurchases(): HasMany
    {
        return $this->hasMany(CoinPurchase::class);
    }
}
