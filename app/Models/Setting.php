<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'jazzcash_account_title',
        'jazzcash_account_number',
        'easy_asa_account_title',
        'easy_asa_account_number',
        'per_coin_price',
    ];
}
