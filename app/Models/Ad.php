<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'target_type',
        'listing_id',
        'target_member_id',
        'external_url',
        'start_date',
        'end_date',
        'status',
        'member_id',
        'coins',
    ];

    public $timestamps = false;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Owner of the ad
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // If ad targets a listing
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // If ad targets a member profile
    public function targetMember()
    {
        return $this->belongsTo(Member::class, 'target_member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (VERY USEFUL)
    |--------------------------------------------------------------------------
    */

    public function isActive()
    {
        return $this->status === 'active'
            && now()->between($this->start_date, $this->end_date);
    }
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function getRedirectUrlAttribute()
    {
        return match ($this->target_type) {
            'listing' => $this->listing ? "/listings/{$this->listing->id}" : null,
            'member' => $this->targetMember ? "/members/{$this->targetMember->id}" : null,
            'external' => $this->external_url,
            default => null,
        };
    }
}
