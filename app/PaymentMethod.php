<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',//string
    ];

    public function sales()
    {
        return $this->belongsToMany('App\Sale', 'payments')->withPivot('value', 'card_number')->using('App\Payment');
    }
}
