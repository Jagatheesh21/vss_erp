<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildProductMaster extends Model
{
    use HasFactory;

    public function invoicepart()
    {
        return $this->belongsTo(ProductMaster::class,'part_id');
    }
}
