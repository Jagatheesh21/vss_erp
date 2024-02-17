<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\ItemProcesmaster;
use App\Http\Requests\StoreItemProcesmasterRequest;
use App\Http\Requests\UpdateItemProcesmasterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ItemProcesmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $itemProcessMasters = ItemProcesmaster::get();
        // dd($itemProcessMasters);
        return view('item_process_master.index',compact('itemProcessMasters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('item_process_master.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemProcesmasterRequest $request)
    {
        //
        // dd($request);
        DB::beginTransaction();
        try {
            $itemProcesmaster = new ItemProcesmaster;
            $itemProcesmaster->operation = $request->operation;
            $itemProcesmaster->operation_type = $request->operation_type;
            $itemProcesmaster->valuation_rate = $request->valuation_rate;
            $itemProcesmaster->prepared_by = auth()->user()->id;
            $itemProcesmaster->save();
            DB::commit();
            return back()->withSuccess('Item Process Master Added Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemProcesmaster $itemProcesmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemProcesmaster $itemProcesmaster)
    {
        //
        // dd($itemProcesmaster);
        return view('item_process_master.edit',compact('itemProcesmaster'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemProcesmasterRequest $request, ItemProcesmaster $itemProcesmaster)
    {
        //
        DB::beginTransaction();
        try {
            $id=$request->id;
            $itemProcesmaster=ItemProcesmaster::find($id);
        // dd($itemProcesmaster);
            $itemProcesmaster->operation = $request->operation;
            $itemProcesmaster->operation_type = $request->operation_type;
            $itemProcesmaster->valuation_rate = $request->valuation_rate;
            $itemProcesmaster->status = $request->status;
            $itemProcesmaster->updated_by = auth()->user()->id;
            $itemProcesmaster->update();
            DB::commit();
            return back()->withSuccess('Item Process Master Is Updated Successfully!');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemProcesmaster $itemProcesmaster)
    {
        //
    }
}
