<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    public $timestamps = false;

	protected $fillable = [
		'created_at',//timestamp
		'user_id',//unsignedBigInteger, nullable()
		'description',//string
		'action',//string
		'errorThrown',//longText
		'status',//enum['Waiting', 'Process', 'Clear']
	];

	protected $dates = [
		'created_at',
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
