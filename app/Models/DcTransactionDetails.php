<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcTransactionDetails extends Model
{
    use HasFactory;

    public function dcmaster()
    {
        return $this->belongsTo(DcMaster::class,'dc_master_id');
    }

    public function rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'rc_id');
    }
    public function uom()
    {
        return $this->belongsTo(ModeOfUnit::class,'uom_id');
    }
}
