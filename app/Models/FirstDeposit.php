<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_id',
        'sender_name',
        'sender_account',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
