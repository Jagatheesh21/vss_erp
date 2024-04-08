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
use App\Http\Requests\StoreInvoiceCorrectionDetailRequest;
use App\Http\Requests\UpdateInvoiceCorrectionDetailRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Carbon\Carbon;
use Auth;

class InvoiceCorrectionDetailController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceCorrectionDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceCorrectionDetail $invoiceCorrectionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceCorrectionDetail $invoiceCorrectionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceCorrectionDetailRequest $request, InvoiceCorrectionDetail $invoiceCorrectionDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceCorrectionDetail $invoiceCorrectionDetail)
    {
        //
    }
}
