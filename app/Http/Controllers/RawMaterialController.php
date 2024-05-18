<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\RawMaterialCategory;
use App\Models\RawMaterial;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use Illuminate\Support\Facades\DB;
use Auth;

// use Illuminate\Support\Facades\DB;



class RawMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-rm|edit-rm|delete-rm', ['only' => ['index','show']]);
        $this->middleware('permission:create-rm', ['only' => ['create','store']]);
        $this->middleware('permission:edit-rm', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-rm', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raw_materials = RawMaterial::with('category')->get();
        $avl_stock=0;
        return view('raw_material.index',compact('raw_materials','avl_stock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RawMaterialCategory::where('status',1)->get();
        $categories2 = RawMaterial::orderBy('material_code', 'DESC')->first();
        $code=$categories2['material_code']??NULL;
            if($code==NULL){
              $new_material_code='RM000000001';
            }else{
                $old_code=str_replace("RM","",$code);
                $old_code_data=str_pad($old_code+1,9,0,STR_PAD_LEFT);
                $new_material_code='RM'.$old_code_data;
            }
        return view('raw_material.create',compact('categories','new_material_code'));
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
            $raw_material->material_code = $request->material_code;
            $raw_material->minimum_stock = $request->minimum_stock;
            $raw_material->maximum_stock = $request->maximum_stock;
            $raw_material->prepared_by = auth()->user()->id;
            $raw_material->save();
            DB::commit();
            return redirect()->route('raw_material.index')->withSuccess('Raw Material Created Successfully!');
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
        // dd($rawMaterial);
        // dd($request);
        DB::beginTransaction();
        try {
            $id=$request->id;
            $rawMaterial=RawMaterial::find($id);
            $rawMaterial->raw_material_category_id = $request->raw_material_category_id;
            $rawMaterial->name = $request->name;
            $rawMaterial->status = $request->status;
            $rawMaterial->material_code = $request->material_code;
            $rawMaterial->minimum_stock = $request->minimum_stock;
            $rawMaterial->maximum_stock = $request->maximum_stock;
            $rawMaterial->updated_by = auth()->user()->id;
            $rawMaterial->update();
            DB::commit();
            return redirect()->route('raw_material.index')->withSuccess('Rawmaterial Updated Successfully!');
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
