<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\SupplierProduct;
use App\Models\Supplier;
use App\Models\ModeOfUnit;
use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
use App\Http\Requests\StoreSupplierProductRequest;
use App\Http\Requests\UpdateSupplierProductRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SupplierProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supplier_products = SupplierProduct::with(['category','product','material','uom'])->get();
        return view('supplier-products.index',compact('supplier_products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = RawMaterialCategory::where('status','=',1)->get();
        $supplier_codes=Supplier::where('status','=',1)->get();
        $units=ModeOfUnit::where('status','=',1)->get();
        return view('supplier-products.create', compact('supplier_codes','categories','units'));
    }

    public function rmcategorydata(Request $request){
        $id=$request->id;
        $count = RawMaterial::where('raw_material_category_id',$id)->where('status','=',1)->get()->count();
        if ($count>0) {
            $rm_datas = RawMaterial::where('raw_material_category_id',$id)->where('status','=',1)->get();
            $rm='<option></option>';
            foreach ($rm_datas as $key => $rm_data) {
                $rm .= '<option value="'.$rm_data->id.'">'.$rm_data->name.'</option>';
            }
            return response()->json(['rm'=>$rm,'count'=>$count]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $supplier_product_data = new SupplierProduct;
            $supplier_product_data->supplier_id = $request->supplier_id;
            $supplier_product_data->raw_material_category_id = $request->raw_material_category_id;
            $supplier_product_data->raw_material_id = $request->raw_material_id;
            $supplier_product_data->products_hsnc = $request->products_hsnc;
            $supplier_product_data->uom_id = $request->uom_id;
            $supplier_product_data->products_rate = $request->products_rate;
            $supplier_product_data->prepared_by = auth()->user()->id;
            $supplier_product_data->save();
            DB::commit();
            return redirect()->route('supplier-products.index')->withSuccess('Supplier Products Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierProduct $supplierProduct)
    {
        //
        // dd($supplierProduct->raw_material_category_id);
        $categories = RawMaterialCategory::where('status','=',1)->get();
        $supplier_codes=Supplier::where('status','=',1)->get();
        $units=ModeOfUnit::where('status','=',1)->get();
        $rm_datas = RawMaterial::where('raw_material_category_id',$supplierProduct->raw_material_category_id)->get();
        return view('supplier-products.edit', compact('supplierProduct','supplier_codes','categories','units','rm_datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierProductRequest $request, SupplierProduct $supplierProduct)
    {
        //
        // dd($request);
        DB::beginTransaction();
        try {
            $id=$request->id;
            $supplier_product_data=SupplierProduct::find($id);
            $supplier_product_data->supplier_id = $request->supplier_id;
            $supplier_product_data->raw_material_category_id = $request->raw_material_category_id;
            $supplier_product_data->raw_material_id = $request->raw_material_id;
            $supplier_product_data->products_hsnc = $request->products_hsnc;
            $supplier_product_data->uom_id = $request->uom_id;
            $supplier_product_data->products_rate = $request->products_rate;
            $supplier_product_data->status = $request->status;
            $supplier_product_data->updated_by = auth()->user()->id;
            $supplier_product_data->update();
            DB::commit();
            return redirect()->route('supplier-products.index')->withSuccess('Supplier Products Updated Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierProduct $supplierProduct)
    {
        //
    }
    public function getRawMaterialCategory(Request $request)
    {
        if($request->input('supplier_id')){
            $supplier_id = $request->input('supplier_id');
            $supplier_products = SupplierProduct::with('category')->where('supplier_id',$supplier_id)->get();
            $html = "";
            if(!empty($supplier_products)){
                foreach($supplier_products as $supplier_product){
                    $html.="<option value='.$supplier_product->raw_material_category_id'>$supplier_product->category->name</option>";
                }
            }
            
            return response()->json(['category'=>$html]);
        }
    }
}
