<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\RackStockmaster;
use App\Http\Requests\StoreRackStockmasterRequest;
use App\Http\Requests\UpdateRackStockmasterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class RackStockmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stockmasters=RackStockmaster::all();
        // dd($stockmasters);
        return view('stock_rack_master.index',compact('stockmasters'));
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
    public function store(StoreRackStockmasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RackStockmaster $rackStockmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RackStockmaster $rackStockmaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRackStockmasterRequest $request, RackStockmaster $rackStockmaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RackStockmaster $rackStockmaster)
    {
        //
    }
}
