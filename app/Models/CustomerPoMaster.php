<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPoMaster extends Model
{
    use HasFactory;

    public function customermaster()
    {
        return $this->belongsTo(CustomerMaster::class,'cus_id');
    }
}
