<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ListingImage extends Model
{
    protected $table = 'listing_images';
    protected $fillable = [
        'listing_id',
        'path',
    ];
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return '/storage/' . $this->path;
    }


    public function updateFile($file): string
    {
        if ($this->path) {
            Storage::disk('public')->delete($this->path);
        }

        return $file->store('listings/gallery', 'public');
    }
    public function deleteWithFile(): void
    {
        if ($this->path) {
            Storage::disk('public')->delete($this->path);
        }

        $this->delete();
    }

    public function listing():belongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
