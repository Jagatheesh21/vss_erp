<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\RackStockmaster;
use App\Models\Rackmaster;
use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
use App\Http\Requests\StoreRackmasterRequest;
use App\Http\Requests\UpdateRackmasterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class RackmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rackmaster_datas=Rackmaster::with(['rackstockmaster','category','material'])->get();
        // dd($rackmaster_datas);
        $available_stock=50;
        return view('rack_master.index',compact('rackmaster_datas','available_stock'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $rackstockmasters=RackStockmaster::where('status','=',1)->get();
        $categories=RawMaterialCategory::where('status','=',1)->get();
        // dd($categories);
        return view('rack_master.create',compact('rackstockmasters','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRackmasterRequest $request)
    {
        //
        // dd($request);
        DB::beginTransaction();
        try {
            $old_rackmaster=Rackmaster::where('raw_material_category_id','=',$request->raw_material_category_id)->where('raw_material_id','=',$request->raw_material_id)->where('rack_name','=',$request->rack_name)->count();
            // dd($old_rackmaster);
            if ($old_rackmaster==0) {
                $new_rackmaster = new Rackmaster;
                $new_rackmaster->raw_material_category_id = $request->raw_material_category_id;
                $new_rackmaster->raw_material_id = $request->raw_material_id;
                $new_rackmaster->rack_name = $request->rack_name;
                $new_rackmaster->stocking_id = $request->stocking_id;
                $new_rackmaster->prepared_by = auth()->user()->id;
                $new_rackmaster->save();
                DB::commit();
                return redirect()->route('rack_master.index')->withSuccess('Rack Master Created Successfully!');
            }else{
                return redirect()->back()->withErrors('Already Raw Material In This Rack.So Please Try Another Rack Number!!!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rackmaster $rackmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rackmaster $rackmaster)
    {
        //
        // dd($rackmaster->raw_material_category_id);
        $rackstockmasters=RackStockmaster::where('status','=',1)->get();
        $categories=RawMaterialCategory::where('status','=',1)->get();
        $rm_datas=RawMaterial::where('raw_material_category_id','=',$rackmaster->raw_material_category_id)->get();
        return view('rack_master.edit',compact('rackmaster','categories','rackstockmasters','rm_datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRackmasterRequest $request, Rackmaster $rackmaster)
    {
        //
        DB::beginTransaction();
        try {
            $old_rackmaster=Rackmaster::where('raw_material_category_id','=',$request->raw_material_category_id)->where('raw_material_id','=',$request->raw_material_id)->where('rack_name','=',$request->rack_name)->count();
            // dd($old_rackmaster);
            if ($old_rackmaster==0) {
                $id=$request->id;
                $rackmaster=Rackmaster::find($id);
                $rackmaster->raw_material_category_id = $request->raw_material_category_id;
                $rackmaster->raw_material_id = $request->raw_material_id;
                $rackmaster->rack_name = $request->rack_name;
                $rackmaster->stocking_id = $request->stocking_id;
                $rackmaster->status = $request->status;
                $rackmaster->updated_by = auth()->user()->id;
                $rackmaster->update();
                DB::commit();
                return redirect()->route('rack_master.index')->withSuccess('Rack Master Created Successfully!');
            }else{
                return redirect()->back()->withErrors('Already Raw Material In This Rack.So Please Try Another Rack Number!!!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rackmaster $rackmaster)
    {
        //
    }
}
