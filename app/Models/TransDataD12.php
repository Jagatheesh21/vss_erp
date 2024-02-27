<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransDataD12 extends Model
{
    use HasFactory;

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

    public function current_rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'rc_id');
    }

    public function previous_rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'previous_rc_id');
    }

}
