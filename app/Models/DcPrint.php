<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcPrint extends Model
{
    use HasFactory;

    public function dctransaction()
    {
        return $this->belongsTo(DcTransactionDetails::class,'dc_id');
    }

}
