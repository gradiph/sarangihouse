3<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',//unsignedBigInteger
        'link',//string
        'text',//text
        'read',//smallInteger
        'created_at',//timestamp
    ];

    protected $dates = [
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
