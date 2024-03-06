<?php

namespace App\Http\Controllers;

use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Http\Requests\StoreDcTransactionDetailsRequest;
use App\Http\Requests\UpdateDcTransactionDetailsRequest;

class DcTransactionDetailsController extends Controller
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
            $suppliers = Supplier::select('id','supplier_code')->get();
            $operations = ItemProcesmaster::select('id','operation')->where('id',17)->get();
            $part_numbers = ProductMaster::all();
            return view('dc.create',compact('suppliers','operations','part_numbers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcTransactionDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDcTransactionDetailsRequest $request, DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }
}
