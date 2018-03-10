<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    public $timestamps = false;

    use SoftDeletes;

    protected $fillable = [
        'id',//char(8), primary, ex: C0000001 | G0000001
        'name',//string, name include thickness and color
        'price',//integer
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function sales()
    {
        return $this->belongsToMany('App\Sale', 'product_sales')->withPivot('size', 'price')->using('App\ProductSale');
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

	public function highlights()
	{
		return $this->hasMany('App\Highlight');
	}
}
