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
        return view('stock_rack_master.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRackStockmasterRequest $request)
    {
        //
        // dd($request->all());
        DB::beginTransaction();
        try {
            $department = new RackStockmaster;
            $department->name = $request->name;
            $department->prepared_by = auth()->user()->id;
            $department->save();
            DB::commit();
            return back()->withSuccess('Stocking Point Rack Master is Created Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
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
        // dd($rackStockmaster);

        return view('stock_rack_master.edit',compact('rackStockmaster'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRackStockmasterRequest $request, RackStockmaster $rackStockmaster)
    {
        //
        // dd($rackStockmaster);
        DB::beginTransaction();
        try {
            $id=$request->id;
            $rackStockmaster=RackStockmaster::find($id);
        // dd($rackStockmaster);
            $rackStockmaster->name = $request->name;
            $rackStockmaster->status = $request->status;
            $rackStockmaster->updated_by = auth()->user()->id;
            $rackStockmaster->update();
            DB::commit();
            return back()->withSuccess('Stocking Point Rack Master Is Updated Successfully!');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RackStockmaster $rackStockmaster)
    {
        //
    }
}
