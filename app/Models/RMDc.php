<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMDc extends Model
{
    use HasFactory;

    public function dc_details()
    {
        return $this->belongsTo(DcTransactionDetails::class,'dc_id');
    }

    public function rm_details()
    {
        return $this->belongsTo(RawMaterial::class,'rm_id');
    }
}
