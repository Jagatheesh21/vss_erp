<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    public function rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'invoice_no');
    }

    public function customerproductmaster()
    {
        return $this->belongsTo(CustomerProductMaster::class,'cus_product_id');
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
}
