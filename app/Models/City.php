<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'name_ar',
        'name_en',
        'wilaya_id',
    ];
    public function getNameAttribute()
    {
        return $this->{"name_" . app()->getLocale()};
    }

    public function wilaya():BelongsTo
    {
        return $this->belongsTo(Wilaya::class);
    }
    public function locations():HasMany
    {
        return $this->hasMany(Location::class);
    }


}

