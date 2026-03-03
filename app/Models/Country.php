<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'name_ar',
        'name_en',
        'flag_path',
        'code',
    ];
    public function getNameAttribute()
    {
        return $this->{"name_" . app()->getLocale()};
    }

    public function wilayas():HasMany
    {
        return $this->hasMany(Wilaya::class);
    }
}
