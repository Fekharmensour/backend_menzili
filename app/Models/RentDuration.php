<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentDuration extends Model
{
    protected $table = 'rent_durations';
    protected $fillable = [
        'name_ar',
        'name_en',
        'name_fr',
        'active',
    ];
    public function getNameAttribute()
    {
        return $this->{"name_" . app()->getLocale()};
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
