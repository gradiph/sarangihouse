<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Highlight extends Model
{
	use SoftDeletes;

    protected $fillable = [
		'product_id',//unsignedBigInteger
		'description',//string
		'category',//enum['promo', 'popular', 'new', 'best_seller', 'event']
	];

	protected $dates = [
		'deleted_at',
	];

	public function product()
	{
		return $this->belongsTo('App\Product');
	}
}
