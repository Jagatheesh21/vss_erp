<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialCategory;
use App\Models\RawMaterial;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use DB;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raw_materials = RawMaterial::with('category')->get();
        return view('raw_material.index',compact('raw_materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RawMaterialCategory::where('status',1)->get();
        return view('raw_material.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRawMaterialRequest $request)
    {
        DB::beginTransaction();
        try {
            $raw_material = new RawMaterial;
            $raw_material->raw_material_category_id = $request->raw_material_category_id;
            $raw_material->name = $request->name;
            $raw_material->save();
            DB::commit();
            return redirect()->back()->withSuccess('Raw Material Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        $categories = RawMaterialCategory::where('status',1)->get();
        return view('raw_material.edit',compact('categories','rawMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        DB::beginTransaction();
        try {
            $rawMaterial->raw_material_category_id = $request->raw_material_category_id;
            $rawMaterial->name = $request->name;
            $rawMaterial->status = $request->status;
            $rawMaterial->save();
            DB::commit();
            return redirect()->back()->withSuccess('Rawmaterial Updated Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        //
    }
}
