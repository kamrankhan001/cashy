<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = ['inviter', 'invitee'];

    public function inviterUser()
    {
        return $this->belongsTo(User::class, 'inviter');
    }

    public function inviteeUser()
    {
        return $this->belongsTo(User::class, 'invitee');
    }
}
