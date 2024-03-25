<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleMaster extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(ProductMaster::class,'part_id');
    }
}
