<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProductMaster extends Model
{
    use HasFactory;


    public function customermaster()
    {
        return $this->belongsTo(CustomerMaster::class,'cus_id');
    }

    public function customerpomaster()
    {
        return $this->belongsTo(CustomerPoMaster::class,'cus_po_id');
    }

    public function uom_masters()
    {
        return $this->belongsTo(ModeOfUnit::class,'uom_id');
    }

    public function currency_masters()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function productmasters()
    {
        return $this->belongsTo(ProductMaster::class,'part_id');
    }
}
