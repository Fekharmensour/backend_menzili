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
    protected $fillable = [
        'user_id',
        'card_id_front_path',
        'card_id_back_path',
        'document_path',
        'member_verified_at',
        'agent_verified_at',
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
}
