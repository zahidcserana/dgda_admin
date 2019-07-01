<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table='accounts';
    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }
}
