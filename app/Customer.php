<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',//string
        'phone',//string(11)
        'user_id',//unsignedBigInteger, nullable
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function sales()
    {
        return $this->hasMany('App\Sale');
    }
}
