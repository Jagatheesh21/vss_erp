<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCorrectionMaster extends Model
{
    use HasFactory;

    public function invoicedetails()
    {
        return $this->belongsTo(InvoiceDetails::class,'invoice_id');
    }

    public function preparedusers()
    {
        return $this->belongsTo(User::class,'prepared_by');
    }

    public function approvedusers()
    {
        return $this->belongsTo(User::class,'approved_by');
    }
}
