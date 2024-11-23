<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'country', 'city', 'address', 'is_admin', 'initial_deposit', 'verified_deposit', 'level', 'last_level', 'work_limit', 'original_work_limit', 'last_viewed_date', 'ref_link', 'last_ref_date'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function firstDeposit()
    {
        return $this->hasOne(FirstDeposit::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function withDrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class, 'inviter');
    }

    public function invitedBy()
    {
        return $this->hasMany(Reference::class, 'invitee');
    }

    public function works()
    {
        return $this->belongsToMany(Work::class, 'assign_works')
            ->withPivot('isVisited') // Include pivot table data
            ->withTimestamps(); // Capture created_at and updated_at
    }

    public function passwordReset()
    {
        return $this->hasOne(PasswordForget::class);
    }
}
