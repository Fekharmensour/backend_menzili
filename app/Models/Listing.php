<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Boolean;

class Listing extends Model
{
    protected $table = 'listings';
    protected $fillable = [
        'title',
        'description',
        'location_id',
        'rent_duration_id',
        'type_id',
        'price',
        'floor',
        'surface',
        'min_duration',
        'number_rooms',
        'number_persons',
        'is_active',
        'is_ready',
        'is_negotiable',
        'verified_at',
        'boost_level',
        'moderation_status',
        'main_image'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_ready' => 'boolean',
            'is_negotiable' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    public function rentDuration(): BelongsTo
    {
        return $this->belongsTo(RentDuration::class);
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function nearPlaces()
    {
        return $this->belongsToMany(NearPlace::class);
    }


}
