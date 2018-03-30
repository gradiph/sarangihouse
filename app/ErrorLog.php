<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
	protected $fillable = [
		'user_id',//unsignedBigInteger, nullable()
		'description',//string
		'action',//string
		'errorThrown',//longText
		'status',//enum['Waiting', 'Process', 'Clear']
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
