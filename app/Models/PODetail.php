<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PODetail extends Model
{
    use HasFactory;

            /**
     * Get the product that owns the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function rcmaster()
    {
        return $this->belongsTo(RouteMaster::class,'ponumber');
    }
}
