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

    public function heat_nomaster()
    {
        return $this->belongsTo(HeatNumber::class,'heat_id');
    }

    public function grndata()
    {
        return $this->belongsTo(GRNInwardRegister::class,'grn_id');
    }

    public function rm_master()
    {
        return $this->belongsTo(RawMaterial::class,'rm_id');
    }
}
