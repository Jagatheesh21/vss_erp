<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoCorrection extends Model
{
    use HasFactory;

    public function podetails()
    {
        return $this->belongsTo(PODetail::class,'po_id');
    }

}
