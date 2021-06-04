<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referrer_id',
        'name',
        'email',
        'password',
        'is_admin',
        'position',
        'referral_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['referral_link'];

    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->name]);
    }

    // A user has a referrer.
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    // A user has many referrals.
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }
}
