<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'member_id',
        'listing_id',
        'rating',
        'review',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
