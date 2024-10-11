<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payment_id',
        'user_id',
    ];
}
