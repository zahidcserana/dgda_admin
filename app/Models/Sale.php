<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    public function items()
    {
        return $this->hasMany('App\Models\SaleItem');
    }

    public function PharmacyBranch()
    {
        return $this->belongsTo('App\Models\PharmacyBranch');
    }
}
