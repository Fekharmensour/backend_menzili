<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'member_id',
        'report',
        'reference_id',
        'reference_type',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // 🔥 polymorphic relation
    public function reference()
    {
        return $this->morphTo();
    }
}
