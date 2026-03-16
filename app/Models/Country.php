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
        return app()->getLocale() == 'ar' ? $this->{"name_ar"} : $this->{"name_en"};
    }

    public function wilayas():HasMany
    {
        return $this->hasMany(Wilaya::class);
    }
}
