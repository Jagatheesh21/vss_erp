<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\GRNInwardRegister;
use App\Models\PODetail;
use App\Models\POProductDetail;
use App\Models\HeatNumber;
use App\Http\Requests\StoreGRNInwardRegisterRequest;
use App\Http\Requests\UpdateGRNInwardRegisterRequest;

class GRNInwardRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $inward_datas=GRNInwardRegister::with(['podata','poproduct','rackmaster'])->where('status','=',1)->get();
        return view('grn_inward.index',compact('inward_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');
		$rc="G";
		$current_rcno=$rc.$current_year;
        $count=GRNInwardRegister::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->get()->count();
        if ($count > 0) {
            $po_data=PODetail::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->first();
            $grnnumber=$po_data['grnnumber']??NULL;
            $old_grnnumber=str_replace("G","",$grnnumber);
            $old_grnnumber_data=str_pad($old_grnnumber+1,9,0,STR_PAD_LEFT);
            $new_grnnumber='G'.$old_grnnumber_data;
        }else{
            $str='000001';
            $new_grnnumber=$current_rcno.$str;
        }
        $po_datas=PODetail::where('status','=',0)->get();
        // dd($po_datas);
        return view('grn_inward.create',compact('po_datas','new_grnnumber','current_date'));
    }

    public function grn_supplierfetchdata(Request $request){
        $id=$request->id;
        $count = PODetail::where('id',$id)->get()->count();
        if ($count>0) {
            $po_datas = PODetail::find($id);
                $sc_id=$po_datas->supplier_id;
                $supplier_datas=Supplier::find($sc_id);
                $sc_name=$supplier_datas->name;
                $po_products=POProductDetail::where('po_id',$id)->get();
                $html='';
            foreach ($po_products as $key => $po_product) {
                $html .= '<option value="'.$po_product->id.'">'.$po_product->name.'</option>';
            }
            return response()->json(['sc_name'=>$sc_name,'html'=>$html]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGRNInwardRegisterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGRNInwardRegisterRequest $request, GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }
}
