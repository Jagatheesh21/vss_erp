<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\Currency;
use App\Models\POProductDetail;
use App\Models\PODetail;
use App\Http\Requests\StorePODetailRequest;
use App\Http\Requests\UpdatePODetailRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PODetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $suppliers = Supplier::get();
        // return view('po.index',compact('suppliers'));
        return view('po.index');
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
		$rc="PO";
		$current_rcno=$rc.$current_year;
        $count=PODetail::where('ponumber','LIKE','%'.$current_rcno.'%')->orderBy('ponumber', 'DESC')->get()->count();
        if ($count > 0) {
            $po_data=PODetail::where('ponumber','LIKE','%'.$current_rcno.'%')->orderBy('ponumber', 'DESC')->first();
            $ponumber=$po_data['ponumber']??NULL;
            $old_ponumber=str_replace("PO","",$ponumber);
            $old_ponumber_data=str_pad($old_ponumber+1,9,0,STR_PAD_LEFT);
            $new_ponumber='PO'.$old_ponumber_data;
        }else{
            $str='000001';
            $new_ponumber=$current_rcno.$str;
        }
        // dd($new_ponumber);
        $suppliers = Supplier::where('status','=','1')->get();
        return view('po.create',compact('suppliers','new_ponumber','current_date'));
    }


    public function posuppliersdata(Request $request){
        $id=$request->id;
        $count = Supplier::where('id',$id)->get()->count();
        if ($count>0) {
            $suppliers = Supplier::where('id',$id)->get();
            $trans_mode='';
            $currency_id='';
            foreach ($suppliers as $key => $supplier) {
                $id=$supplier->id;
                $name=$supplier->name;
                $gst_number=$supplier->gst_number;
                $address=$supplier->address;
                $contact_number=$supplier->contact_number;
                $contact_person=$supplier->contact_person;
                $packing_charges=$supplier->packing_charges;
                $cgst=$supplier->cgst;
                $sgst=$supplier->sgst;
                $igst=$supplier->igst;
                $remarks=$supplier->remarks;
                $trans_mode .= '<option value="'.$supplier->trans_mode.'">'.$supplier->trans_mode.'</option>';
                $currency_data=Currency::find($supplier->currency_id);
                $currency_data->name;
                $currency_id .= '<option value="'.$supplier->currency_id.'" selected>'.$currency_data->name.'</option>';

            }
        $count2 = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->get()->count();
        if ($count2>0) {
            $supplier_products = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->get();
            $category='<option></option>';
            foreach ($supplier_products as $key => $supplier_product) {
                $category .= '<option value="'.$supplier_product->raw_material_category_id.'">'.$supplier_product->category->name.'</option>';
            }
        }

            return response()->json(['id'=>$id,'name'=>$name,'gst_number'=>$gst_number,'address'=>$address,'contact_person'=>$contact_person,'contact_number'=>$contact_number,'packing_charges'=>$packing_charges,'trans_mode'=>$trans_mode,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'remarks'=>$remarks,'currency_id'=>$currency_id,'count'=>$count,'count2'=>$count2,'category'=>$category]);
        }else {
            $currency_id='';
            $trans_mode = '<option value="BY ROAD">BY ROAD</option>';
            $trans_mode .= '<option value="BY COURIER">BY COURIER</option>';
            $currency_datas=Currency::get();
            foreach ($currency_datas as $key => $currency_data) {
                $currency_id .= '<option value="'.$currency_data->id.'">'.$currency_data->name.'</option>';

            }
            return response()->json(['count'=>$count,'trans_mode'=>$trans_mode,'currency_id'=>$currency_id,'supplier_code'=>$id]);
        }
        // return $id;
    }


    public function posuppliersrmdata($raw_material_category_id,$scode){
        return response()->json(['data'=>$raw_material_category_id,'code'=>$scode]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePODetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PODetail $pODetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PODetail $pODetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePODetailRequest $request, PODetail $pODetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PODetail $pODetail)
    {
        //
    }
}
