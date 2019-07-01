<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function medicineType()
    {
        return $this->belongsTo('App\Models\MedicineType');
    }
}
