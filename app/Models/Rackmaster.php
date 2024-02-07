<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rackmaster extends Model
{
    use HasFactory;

    public function rackstockmaster()
    {
        return $this->belongsTo(RackStockmaster::class,'stocking_id');
    }

        /**
     * Get the category that owns the RawMaterial
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(RawMaterialCategory::class,'raw_material_category_id');
    }

        /**
     * Get the category that owns the RawMaterial
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material()
    {
        return $this->belongsTo(RawMaterial::class,'raw_material_id');
    }
}
