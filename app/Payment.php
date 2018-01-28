<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Payment extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'sale_id',//unsignedBigInteger
        'payment_method_id',//unsignedSmallInteger
        'value',//integer
        'card_number',//string
    ];
}
