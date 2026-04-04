<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargilyPayment extends Model
{
    use HasFactory;
    protected $table = 'chargily_payments';
    protected $fillable = ["user_id","status","currency","amount"];
}
