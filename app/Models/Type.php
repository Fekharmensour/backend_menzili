<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "types";
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
}
