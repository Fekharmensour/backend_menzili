<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'title_ar',
        'title_en',
        'title_fr',

        'body_ar',
        'body_en',
        'body_fr',

        'user_id',
        'type',
        'is_read',
        'icon',
        'reference_type',
        'reference_id',
    ];

    public function getTitleAttribute()
    {
        return $this->{"title_" . app()->getLocale()};
    }

    public function getBodyAttribute()
    {
        return $this->{"body_" . app()->getLocale()};
    }

    protected $casts = [
        'is_read' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reference(){

    }
}
