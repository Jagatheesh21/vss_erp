<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransDataD13 extends Model
{
    use HasFactory;

    public function current_rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'rc_id');
    }

    public function previous_rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'previous_rc_id');
    }
}
