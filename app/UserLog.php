<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'created_at',//timestamp
        'user_id',//unsignedBigInteger
        'description',//string
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
