<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customer_id',//unsignedBigInteger
        'postal_code',//string(5)
        'street_1',//string
        'street_2',//string
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
