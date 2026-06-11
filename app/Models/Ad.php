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
        'ads_plan_id',
    ];

    public $timestamps = false;
    protected $appends = ['image_path', 'redirect_url'];

    public function getImagePathAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return str_replace(['/storage/', 'storage/'], '', $value);
    }

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

    /**
     * Relationship with the selected plan.
     */
    public function adsPlan()
    {
        return $this->belongsTo(AdsPlan::class);
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

    public function updateImage($file): string
    {
        if ($this->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->image_path);
        }

        $path = app(\App\Services\Image\ImageService::class)->storeAsWebp($file, 'ads');
        
        $this->image_path = $path;
        $this->save();

        return $path;
    }
}
