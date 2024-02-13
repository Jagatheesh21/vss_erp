<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
// use App\Models\User;
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
        $po_datas=PODetail::with(['supplier'])->get();
        // return view('po.index',compact('suppliers'));
        return view('po.index',compact('po_datas'));
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
        $count2 = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->where('status','=','1')->get()->count();
        if ($count2>0) {
            $supplier_products = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->where('status','=','1')->groupBy('raw_material_category_id')->get();
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
            $currency_datas=Currency::where('status','=','1')->get();
            foreach ($currency_datas as $key => $currency_data) {
                $currency_id .= '<option value="'.$currency_data->id.'">'.$currency_data->name.'</option>';

            }
            return response()->json(['count'=>$count,'trans_mode'=>$trans_mode,'currency_id'=>$currency_id,'supplier_code'=>$id]);
        }
        // return $id;
    }


    public function posuppliersproductdata(Request $request){
        // return json_encode($request->all());
        if($request->raw_material_category_id){
            $raw_material_category_id = $request->raw_material_category_id;
            $supplier_id = $request->supplier_id;
            $supplier_product_id = $request->supplier_product_id;
            $supplier_products = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$supplier_id)->where('raw_material_category_id',$raw_material_category_id)->where('raw_material_id',$supplier_product_id)->where('status','=','1')->get();
            foreach($supplier_products as $product){
                $html='<option value="'.$product->uom->id.' selected">'.$product->uom->name.'</option>';
                $products_hsnc=$product->products_hsnc;
                $products_rate=$product->products_rate;
            }
            // return $html;
            return response()->json(['html'=>$html,'products_hsnc'=>$products_hsnc,'products_rate'=>$products_rate]);

        }
    }
    public function posuppliersrmdata(Request $request){
        //return json_encode($request->all());
        if($request->raw_material_category_id){
            $raw_material_category_id = $request->raw_material_category_id;
            $supplier_id = $request->supplier_id;
            $supplier_rmdatas = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$supplier_id)->where('raw_material_category_id',$raw_material_category_id)->where('status','=','1')->get();
            $html = '<option></option>';
            foreach($supplier_rmdatas as $rmdata){
                $html.='<option value="'.$rmdata->material->id.'">'.$rmdata->material->name.'</option>';
            }
            return $html;
        }
    }

    public function poprint(Request $request){
        $id=$request->id;
        dd($id);
    }

    public function pocorrection(Request $request){
        $id=$request->id;
        $user_id=auth()->user()->id;
        $po_datas=PODetail::with(['supplier'])->where('status','!=',1)->where('id','=',$id)->get();
        $total_rate=POProductDetail::where('po_id','=',$id)->sum('rate');
        return view('po_correction.create',compact('po_datas','total_rate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePODetailRequest $request)
    {
        DB::beginTransaction();
        try {
            $po_datas = new PODetail;
            $po_datas->ponumber = $request->ponumber;
            $po_datas->podate = $request->podate;
            $po_datas->purchasetype = $request->purchasetype;
            $po_datas->payment_terms = $request->payment_terms;
            $po_datas->supplier_id = $request->supplier_id;
            $po_datas->indentno = $request->indentno;
            $po_datas->indentdate = $request->indentdate;
            $po_datas->quotno = $request->quotno;
            $po_datas->quotdt = $request->quotdt;
            $po_datas->remarks1 = $request->remarks1;
            $po_datas->remarks2 = $request->remarks2;
            $po_datas->remarks3 = $request->remarks3;
            $po_datas->remarks4 = $request->remarks4;
            $po_datas->prepared_by = auth()->user()->id;
            $po_datas->save();
            $po_id=$po_datas->id;
            $raw_material_category_datas=$request->raw_material_category_id;
            foreach ($raw_material_category_datas as $key => $raw_material_category_data) {
                $po_product_datas = new POProductDetail;
                $po_product_datas->po_id =$po_id;
                $po_product_datas->supplier_id =$request->supplier_id;
                $po_product_datas->supplier_product_id =$request->supplier_product_id[$key];
                $po_product_datas->duedate =$request->duedate[$key];
                $po_product_datas->qty =$request->qty[$key];
                $po_product_datas->rate =$request->rate[$key];
                $po_product_datas->prepared_by = auth()->user()->id;
                $po_product_datas->save();
            }
            DB::commit();
            return redirect()->route('po.index')->withSuccess('Purchase Order Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            //dd($th->getMessage());
            return response()->json(['errors' => $th->getMessage()]);
            // return redirect()->back()->withErrors($th->getMessage());
        }
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
        dd($pODetail);
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
    public function addPurchaseItem(Request $request)
    {
        if($request->supplier_id)
        {
            $supplier_id = $request->supplier_id;
            $count2 = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$supplier_id)->where('status','=','1')->get()->count();
            if ($count2>0) {
                $supplier_products = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$supplier_id)->where('status','=','1')->groupBy('raw_material_category_id')->get();
                $html = view('po.add_items',compact('supplier_products'))->render();
                return response()->json(['category'=>$html]);
            }

        }
    }
}
