<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POProductDetail extends Model
{
    use HasFactory;

        /**
     * Get the product that owns the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function podetails()
    {
        return $this->belongsTo(PODetail::class,'po_id');
    }

    /**
     * Get the product that owns the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    /**
    * Get the product that owns the Supplier
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function supplier_products()
   {
       return $this->belongsTo(SupplierProduct::class,'supplier_product_id');
   }


   public function product_names()
   {
       return $this->belongsTo(RawMaterial::class,'supplier_product_id');
   }

}
