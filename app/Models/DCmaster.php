<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcMaster extends Model
{
    use HasFactory;

    public function procesmaster()
    {
        return $this->belongsTo(ItemProcesmaster::class,'operation_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
