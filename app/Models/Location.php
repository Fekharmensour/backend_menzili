<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'latitude',
        'longitude',
        'altitude',
        'zip_code',
        'city_id',
    ];

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
