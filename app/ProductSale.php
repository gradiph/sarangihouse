<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSale extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',//char(8)
        'sale_id',//unsignedBigInteger
        'size',//string
        'price',//integer
    ];
}
