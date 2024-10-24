<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'daily_earning',
        'last_earning_date',
        'referral_bonus',
        'extra_coins',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
