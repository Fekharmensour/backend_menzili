<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\This;

class Listing extends Model
{
    protected $table = 'listings';
    protected $fillable = [
        'title',
        'description',
        'location_id',
        'rent_duration_id',
        'member_id',
        'type_id',
        'price',
        'floor',
        'surface',
        'min_duration',
        'number_rooms',
        'number_persons',
        'is_active',
        'is_banned',
        'is_ready',
        'is_negotiable',
        'verified_at',
        //        'boost_level',
        'moderation_status',
        'main_image',
        'rating_avg',
        'reviews_count',
        'views',
        'active_boost_id',
        'final_score'
    ];

    //    protected $with = [
//        'rentDuration',
//        'location.city.wilaya.country'
//    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_banned' => 'boolean',
            'is_ready' => 'boolean',
            'is_negotiable' => 'boolean',
            'verified_at' => 'datetime',
            //            'boost_level' => 'integer',
            'price' => 'float',
            'floor' => 'integer',
            'surface' => 'float',
            'min_duration' => 'integer',
            'number_rooms' => 'integer',
            'number_persons' => 'integer',

        ];
    }

    protected static function booted()
    {
        static::addGlobalScope('not_banned', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('is_banned', false);
        });
    }

    protected function isBoosted(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn() => (bool) $this->active_boost_id,
        );
    }

    protected $appends = ['main_image', 'is_boosted'];

    public function getMainImageAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return str_replace(['/storage/', 'storage/'], '', $value);
    }
    public function updateMainImage($file): string
    {
        if ($this->main_image) {
            Storage::disk('public')->delete($this->main_image);
        }

        return $file->store('listings', 'public');
    }
    public function deleteWithMedia(): void
    {
        // Delete main image
        if ($this->main_image) {
            Storage::disk('public')->delete($this->main_image);
        }

        // Delete gallery images
        foreach ($this->images as $image) {
            $image->deleteWithFile();
        }

        $this->delete();
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

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function toSearchableText(): string
    {
        $this->loadMissing([
            'location.city.wilaya',
            'type',
            'rentDuration',
            'features',
            'nearPlaces'
        ]);

        return "
                Property Listing:

                Title: {$this->title}

                Description:
                {$this->description}

                Price: {$this->price} DZD
                Type: " . optional($this->type)->name . "
                Purpose: " . (optional($this->type)->name_en ?? 'N/A') . "

                Details:
                        - Rooms: {$this->number_rooms}
                        - Persons: {$this->number_persons}
                        - Surface: {$this->surface} m²
                        - Floor: {$this->floor}

                Location:
                        - City: " . optional($this->location->city)->name . "
                        - Wilaya: " . optional($this->location->city->wilaya)->name . "

                Features:
                        " . $this->features->pluck('name')->join(', ') . "

                Near Places:
                        " . $this->nearPlaces->pluck('name')->join(', ') . "
                        ";
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function updateRating()
    {
        $this->rating_avg = $this->reviews()->avg('rating') ?? 4;
        $this->reviews_count = $this->reviews()->count();
        $this->save();
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reference');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    // Boost relationships
    public function activeBoost(): BelongsTo
    {
        return $this->belongsTo(Boost::class, 'active_boost_id');
    }

    public function boosts(): HasMany
    {
        return $this->hasMany(Boost::class);
    }

    // Score calculation methods
    public function getBoostScore(): float
    {
        return $this->activeBoost?->coins_spent ?? 0;
    }

    public function getViewsScore(): float
    {
        return log(1 + ($this->views ?? 0));
    }

    public function getRatingScore(): float
    {
        $rating = $this->rating_avg ?? 0;
        $reviews = $this->reviews_count ?? 0;

        return $rating * log(1 + $reviews);
    }

    public function calculateFinalScore(): float
    {
        $boostScore = $this->getBoostScore();
        $viewsScore = $this->getViewsScore();
        $ratingScore = $this->getRatingScore();

        return ($boostScore * 0.7) + ($viewsScore * 0.2) + ($ratingScore * 0.1);
    }

    public function updateFinalScore(): void
    {
        $this->update(['final_score' => $this->calculateFinalScore()]);
    }
}
