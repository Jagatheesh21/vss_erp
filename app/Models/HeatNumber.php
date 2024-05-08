<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeatNumber extends Model
{
    use HasFactory;

    public function grndata()
    {
        return $this->belongsTo(GRNInwardRegister::class,'grnnumber_id');
    }


    public function rackmaster()
    {
        return $this->belongsTo(Rackmaster::class,'rack_id');
    }

}
