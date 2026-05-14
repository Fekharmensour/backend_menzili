<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdsPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coins',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'coins' => 'integer',
        'duration_days' => 'integer',
    ];

    /**
     * Get all ads associated with this plan.
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
}
