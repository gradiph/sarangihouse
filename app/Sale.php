<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'created_at',//timestamp
        'customer_id',//unsignedBigInteger
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany('App\PaymentMethod', 'payments')->withPivot('value', 'card_number')->using('App\Payment');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_sales')->withPivot('size', 'price')->using('App\ProductSale');
    }
}
