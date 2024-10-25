<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id',
        'level_number',
        'members',
        'task_income',
        'referral_bonus',
        'extra_coins',
    ];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
