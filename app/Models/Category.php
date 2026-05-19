<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name_ar',
        'name_en',
        'name_fr',
        'icon',
        'icon_path',
        'description',
        'active',
    ];
    public function getNameAttribute()
    {
        return $this->{"name_" . app()->getLocale()};
    }

    protected $appends = ['name', 'icon_path'];

    public function getIconPathAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return str_replace(['/storage/', 'storage/'], '', $value);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
    public function listings():HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
