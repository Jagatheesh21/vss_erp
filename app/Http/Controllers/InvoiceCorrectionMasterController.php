<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BomMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\ProductProcessMaster;
use App\Models\ChildProductMaster;
use App\Models\CustomerMaster;
use App\Models\CustomerPoMaster;
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\InvoiceDetails;
use App\Models\InvoicePrint;
use App\Models\InvoiceCorrectionMaster;
use App\Models\InvoiceCorrectionDetail;
use App\Http\Requests\StoreInvoiceCorrectionMasterRequest;
use App\Http\Requests\UpdateInvoiceCorrectionMasterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Carbon\Carbon;
use Auth;

class InvoiceCorrectionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $invoiceDetails=InvoiceDetails::with('rcmaster')->where('status','=',1)->get();
        // dd($invoiceDetails);
        return view('invoice_correction.create',compact('invoiceDetails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceCorrectionMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceCorrectionMaster $invoiceCorrectionMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceCorrectionMaster $invoiceCorrectionMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceCorrectionMasterRequest $request, InvoiceCorrectionMaster $invoiceCorrectionMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceCorrectionMaster $invoiceCorrectionMaster)
    {
        //
    }
}
