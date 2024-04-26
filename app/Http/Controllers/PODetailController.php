<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\Currency;
use App\Models\POProductDetail;
use App\Models\PODetail;
use App\Models\PoCorrection;
use App\Models\RouteMaster;
use App\Models\ItemProcesmaster;
use App\Http\Requests\StorePODetailRequest;
use App\Http\Requests\UpdatePODetailRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class PODetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $po_datas=PODetail::with(['supplier','rcmaster'])->get();
        // dd($po_datas[0]->rcmaster);
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
        $process=ItemProcesmaster::where('operation','=','Purchase Order')->where('status','=',1)->first();
        $process_id=$process->id;
        $count1=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        // $count=PODetail::where('ponumber','LIKE','%'.$current_rcno.'%')->orderBy('ponumber', 'DESC')->get()->count();
        if ($count1 > 0) {
            // $po_data=PODetail::where('ponumber','LIKE','%'.$current_rcno.'%')->orderBy('ponumber', 'DESC')->first();
            $po_data=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $ponumber=$po_data['rc_id']??NULL;
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

    public function grn_supplierfetchdata(Request $request){
        $id=$request->id;
        $count = PODetail::where('id',$id)->get()->count();
        if ($count>0) {
            $po_datas = PODetail::find($id);
                $sc_id=$po_datas->supplier_id;
                $supplier_datas=Supplier::find($sc_id);
                $sc_name=$supplier_datas->name;
                $po_products=POProductDetail::with(['suppliers','product_names'])->where('po_id',$id)->get();
                $html='<option value="" selected></option>';
            foreach ($po_products as $key => $po_product) {
                $html .= '<option value="'.$po_product->id.'">'.$po_product->product_names->name.'</option>';
            }
            return response()->json(['sc_name'=>$sc_name,'html'=>$html,'count'=>$count]);
        }
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
        // dd($id);
        $po_datas=PODetail::with(['supplier','rcmaster'])->find($id);
        // dd($po_datas);

        $po_product_datas=POProductDetail::with(['supplier_products','uom_datas'])->where('po_id','=',$id)->get();
        // dd($po_product_datas);
        $total_basic_value=POProductDetail::where('po_id','=',$id)->sum('basic_value');
        $total_packing_charge_amt=POProductDetail::where('po_id','=',$id)->sum('packing_charge_amt');
        $total_cgstamt=POProductDetail::where('po_id','=',$id)->sum('cgstamt');
        $total_sgstamt=POProductDetail::where('po_id','=',$id)->sum('sgstamt');
        $total_igstamt=POProductDetail::where('po_id','=',$id)->sum('igstamt');
        $tax_amount=round((($total_packing_charge_amt)+($total_cgstamt)+($total_sgstamt)+($total_igstamt)),2);
        $po_total=round(($total_basic_value+$tax_amount),2);
        // dd($total_basic_value);
        $qrCodes=QrCode::size(75)->style('round')->generate($id);
        $html = view('po.po_print',compact('po_datas','total_basic_value','po_product_datas','qrCodes','total_packing_charge_amt','total_cgstamt','total_sgstamt','total_igstamt','tax_amount','po_total'))->render();
        $pdf=Browsershot::html($html)->setIncludePath(config('services.browsershot.include_path'))->format('A4')->pdf();
        return new Response($pdf,200,[
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline;filename="po.pdf"'
        ]);

    }

    public function pocorrection(Request $request){
        $id=$request->id;
        $user_id=auth()->user()->id;
        $po_datas=PODetail::with(['supplier','rcmaster'])->where('status','!=',0)->where('id','=',$id)->get();
        $total_rate=POProductDetail::where('po_id','=',$id)->sum('rate');
        return view('po_correction.create',compact('po_datas','total_rate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePODetailRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $process=ItemProcesmaster::where('operation','=','Purchase Order')->where('status','=',1)->first();
            $process_id=$process->id;

            $rcMaster=new RouteMaster;
            $rcMaster->create_date=$request->podate;
            $rcMaster->process_id=$process_id;
            $rcMaster->rc_id=$request->ponumber;
            $rcMaster->prepared_by=auth()->user()->id;
            $rcMaster->save();

            $rcMasterData=RouteMaster::where('rc_id','=',$request->ponumber)->where('process_id','=',$process_id)->first();
            $rc_id=$rcMasterData->id;

            $po_datas = new PODetail;
            $po_datas->ponumber = $rc_id;
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
                $part_rate=round(($request->products_rate[$key]),2);
                $sup_cgst=(($request->cgst*0.01));
                $sup_sgst=(($request->sgst*0.01));
                $sup_igst=(($request->igst*0.01));
                $sup_packing_charge=(($request->packing_charges*0.01));
                $basic_value=round((($part_rate)*($request->qty[$key])),2);
                $totalcgst_amt=round((($basic_value)*($sup_cgst)),2);
                $totalsgst_amt=round((($basic_value)*($sup_sgst)),2);
                $totaligst_amt=round((($basic_value)*($sup_igst)),2);
                $totalpacking_charge=round((($basic_value)*($sup_packing_charge)),2);
                $pototal=(($basic_value)+($totalcgst_amt)+($totalsgst_amt)+($totaligst_amt)+($totalpacking_charge));
                $po_product_datas->uom_id=$request->uom_id[$key];
                $po_product_datas->rate=$part_rate;
                $po_product_datas->currency_id=$request->currency_id;
                $po_product_datas->packing_charge=$request->packing_charges;
                $po_product_datas->cgst=$request->cgst;
                $po_product_datas->sgst=$request->sgst;
                $po_product_datas->igst=$request->igst;
                // $po_product_datas->tcs=$customer_product_uom;
                $po_product_datas->basic_value=$basic_value;
                $po_product_datas->packing_charge_amt=$totalpacking_charge;
                $po_product_datas->cgstamt=$totalcgst_amt;
                $po_product_datas->sgstamt=$totalsgst_amt;
                $po_product_datas->igstamt=$totaligst_amt;
                // $po_product_datas->tcsamt=$customer_product_uom;
                $po_product_datas->pototal=$pototal;
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
    public function edit($id)
    {
        // dd($id);
        $suppliers = Supplier::where('status','=','1')->get();
        $podatas=PODetail::with(['supplier','rcmaster'])->find($id);
        $poProductDatas=POProductDetail::with(['suppliers','product_names'])->where('po_id','=',$id)->get();
        $total_basic_value=POProductDetail::with(['suppliers','product_names'])->where('po_id','=',$id)->sum('basic_value');
        // dd($podatas);
        $currency_datas=Currency::where('status','=','1')->get();
        $supplier_products = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->where('status','=','1')->groupBy('raw_material_category_id')->get();
        // $supplier_rmdatas = SupplierProduct::with(['category','product','material','uom'])->where('supplier_id',$id)->where('raw_material_category_id',$raw_material_category_id)->where('status','=','1')->get();

        return view('po.edit',compact('podatas','poProductDatas','suppliers','currency_datas','supplier_products','total_basic_value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePODetailRequest $request, PODetail $pODetail)
    {
        //
        // dd($request->all());
        DB::beginTransaction();
        try {
            $po_datas = PODetail::find($request->id);
            // dd($po_datas);
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
            $po_datas->correction_status=0;
            $po_datas->updated_by = auth()->user()->id;
            $po_datas->updated_at = Carbon::now();
            $po_datas->update();

            $old_po_product_dats=POProductDetail::where('po_id','=',$request->id)->get()->each->delete();

            $po_id=$po_datas->id;
            $raw_material_category_datas=$request->raw_material_category_id;
            foreach ($raw_material_category_datas as $key => $raw_material_category_data) {
                $po_product_datas = new POProductDetail;
                $po_product_datas->po_id =$po_id;
                $po_product_datas->supplier_id =$request->supplier_id;
                $po_product_datas->supplier_product_id =$request->supplier_product_id[$key];
                $po_product_datas->duedate =$request->duedate[$key];
                $po_product_datas->qty =$request->qty[$key];
                $part_rate=round(($request->products_rate[$key]),2);
                $sup_cgst=(($request->cgst*0.01));
                $sup_sgst=(($request->sgst*0.01));
                $sup_igst=(($request->igst*0.01));
                $sup_packing_charge=(($request->packing_charges*0.01));
                $basic_value=round((($part_rate)*($request->qty[$key])),2);
                $totalcgst_amt=round((($basic_value)*($sup_cgst)),2);
                $totalsgst_amt=round((($basic_value)*($sup_sgst)),2);
                $totaligst_amt=round((($basic_value)*($sup_igst)),2);
                $totalpacking_charge=round((($basic_value)*($sup_packing_charge)),2);
                $pototal=(($basic_value)+($totalcgst_amt)+($totalsgst_amt)+($totaligst_amt)+($totalpacking_charge));
                $po_product_datas->uom_id=$request->uom_id[$key];
                $po_product_datas->rate=$part_rate;
                $po_product_datas->currency_id=$request->currency_id;
                $po_product_datas->packing_charge=$request->packing_charges;
                $po_product_datas->cgst=$request->cgst;
                $po_product_datas->sgst=$request->sgst;
                $po_product_datas->igst=$request->igst;
                // $po_product_datas->tcs=$customer_product_uom;
                $po_product_datas->basic_value=$basic_value;
                $po_product_datas->packing_charge_amt=$totalpacking_charge;
                $po_product_datas->cgstamt=$totalcgst_amt;
                $po_product_datas->sgstamt=$totalsgst_amt;
                $po_product_datas->igstamt=$totaligst_amt;
                // $po_product_datas->tcsamt=$customer_product_uom;
                $po_product_datas->pototal=$pototal;
                $po_product_datas->prepared_by = auth()->user()->id;
                $po_product_datas->save();
            }
            DB::commit();
            // return redirect()->back()->withSuccess('Purchase Order Corrected Successfully!');
            return response()->json(['success' => 'Purchase Order Corrected Successfully!']);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            //dd($th->getMessage());
            return response()->json(['errors' => $th->getMessage()]);
            // return redirect()->back()->withErrors($th->getMessage());
        }

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
