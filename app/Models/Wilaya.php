<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilaya extends Model
{
    protected $table = 'wilayas';
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'country_id',
    ];
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->{"name_ar"} : $this->{"name_en"};
    }

    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities():HasMany
    {
        return $this->hasMany(City::class);
    }
}
