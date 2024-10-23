<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_id',
        'isVisited',
    ];
}
