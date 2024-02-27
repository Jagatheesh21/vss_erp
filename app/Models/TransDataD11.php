<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransDataD11 extends Model
{
    use HasFactory;

    public function rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'rc_id');
    }

    public function partmaster()
    {
        return $this->belongsTo(ChildProductMaster::class,'part_id');
    }

    public function currentprocessmaster()
    {
        return $this->belongsTo(ItemProcesmaster::class,'process_id');
    }

    public function currentproductprocessmaster()
    {
        return $this->belongsTo(ProductProcessMaster::class,'product_process_id');
    }
    public function nextprocessmaster()
    {
        return $this->belongsTo(ItemProcesmaster::class,'next_process_id');
    }

    public function nextproductprocessmaster()
    {
        return $this->belongsTo(ProductProcessMaster::class,'next_product_process_id');
    }
}
