<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',//unsignedBigInteger
        'product_id',//unsignedBigInteger
        'created_at',//timestamp
    ];

    protected $dates = [
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
