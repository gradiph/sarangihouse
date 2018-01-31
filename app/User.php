<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',//string
        'kakao_id',//string, unique, nullable
        'email',//string, unique, nullable
        'password',//string
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function logs()
    {
        return $this->hasMany('App\UserLog');
    }

    public function wishlists()
    {
        return $this->hasMany('App\WishList');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
