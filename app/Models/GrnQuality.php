<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrnQuality extends Model
{
    use HasFactory;

    public function grn_data()
    {
        return $this->belongsTo(GRNInwardRegister::class,'grnnumber_id');
    }

    public function heat_no_data()
    {
        return $this->belongsTo(HeatNumber::class,'heat_no_id');
    }

    public function rack_data()
    {
        return $this->belongsTo(Rackmaster::class,'rack_id');
    }
}
