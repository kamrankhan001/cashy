<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'assign_works')
            ->withPivot('isVisited')  // Include pivot table data
            ->withTimestamps();  // Capture created_at and updated_at
    }
}
