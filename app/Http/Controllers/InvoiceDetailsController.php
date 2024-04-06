<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
use App\Models\DcPrint;
use App\Models\BomMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\ProductProcessMaster;
use App\Models\ChildProductMaster;
use App\Models\CustomerMaster;
use App\Models\CustomerPoMaster;
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\InvoiceDetails;
use App\Http\Requests\StoreInvoiceDetailsRequest;
use App\Http\Requests\UpdateInvoiceDetailsRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('invoice.invoice_index');
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
        if ( date('m') > 3 ) {
            $year = date('y');
            $next_year=date('y')+1;
            $finacial_year=$year.$next_year;
        }
        else {
            $year = date('y') - 1;
            $next_year=date('y');
            $finacial_year=$year.$next_year;
        }
        // dd($finacial_year);
            $rc="U1";
		$current_rcno=$rc.$finacial_year;
        $count1=RouteMaster::where('process_id',22)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        if ($count1 > 0) {
            $rc_data=RouteMaster::where('process_id',22)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $rcnumber=$rc_data['rc_id']??NULL;
            $old_rcnumber=str_replace($current_rcno,"-",$rcnumber);
            $old_rcnumber_data=str_pad($old_rcnumber+1,5,0,STR_PAD_LEFT);
            $new_rcnumber=$current_rcno.$old_rcnumber_data;
        }else{
            $str='00001';
            $new_rcnumber=$current_rcno."-".$str;
        }
        // dd($new_rcnumber);
        // $customer_product_masterdatas=CustomerProductMaster::with('customermaster','customerpomaster','uom_masters','currency_masters','productmasters')->where('status','=',1)->get();
        $customer_masterdatas=CustomerMaster::where('status','=',1)->get();
        // dd($customer_masterdatas);
        return view('invoice.invoice_create',compact('new_rcnumber','current_date','customer_masterdatas'));
    }


    public function cusPartData(Request $request){
        // dd($request->cus_id);
        $cus_id=$request->cus_id;
        $customerDatas=CustomerMaster::find($cus_id);
        $cus_name=$customerDatas->cus_name;
        $cus_gst_number=$customerDatas->cus_gst_number;
        // dd($cus_id);
        $count=CustomerProductMaster::with('productmasters')->where('status','=',1)->where('cus_id','=',$cus_id)->get()->count();
        // dd($count);
        if ($count > 0) {
            $customer_product_masterdatas=DB::table('customer_product_masters as a')
            ->join('product_masters AS b', 'a.part_id', '=', 'b.id')
            ->select('b.id as part_id','b.part_no')
            ->where('a.cus_id','=',$cus_id)
            ->orderBy('a.id', 'ASC')
            ->get();
        // dd($customer_product_masterdatas);
            $part_id='<option value="" selected>Select The Part Number</option>';
            foreach ($customer_product_masterdatas as $key => $customer_product_masterdata) {
                $part_id.='<option value="'.$customer_product_masterdata->part_id.'">'.$customer_product_masterdata->part_no.'</option>';
            }
            // $customer_product_masterdatas=CustomerProductMaster::with('productmasters')->where('status','=',1)->where('cus_id','=',$cus_id)->get();
            // $part_id='<option value="" selected>Select The Part Number</option>';
            // foreach ($customer_product_masterdatas as $key => $customer_product_masterdata) {
            //     $part_id.='<option value="'.$customer_product_masterdata->product_masters->id.'">'.$customer_product_masterdata->product_masters->part_no.'</option>';
            // }
        return response()->json(['count'=>$count,'part_id'=>$part_id,'cus_name'=>$cus_name,'cus_gst_number'=>$cus_gst_number]);
        }else{
            return response()->json(['count'=>$count]);
        }
    }


    public function invoiceItemRc(Request $request){
        // dd($request->all());
        $cus_id=$request->cus_id;
        $part_id=$request->part_id;

        $customer_po_datas=CustomerPoMaster::where('part_id','=',$part_id)->where('cus_id','=',$cus_id)->where('status','=',1)->first();
        $cus_po_no='<option value="'.$customer_po_datas->id.'" selected>'.$customer_po_datas->cus_po_no.'</option>';

        // dd($cus_po_no);
        // $part_id=$request->part_id;
        // $cus_id1=$request->supplier_id;
        $bomDatas=BomMaster::find($part_id);
        $bom=$bomDatas->manual_usage;
        $check=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->count();
        $check1=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->where('item_type','=',1)->count();
        $check2=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->where('item_type','=',0)->count();
        $manufacturingPartDatas=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->get();
        // dd($check1);
                if ($check1==1) {
                    // dd('ok');
                    foreach ($manufacturingPartDatas as $key => $manufacturingPartData) {
                        $manufacturingPart=$manufacturingPartData->id;
                        $itemType=$manufacturingPartData->item_type;
                    }
                    if ($itemType==1) {
                        $invoicemasterOperationDatas=CustomerProductMaster::with('customermaster','customerpomaster','uom_masters','currency_masters','productmasters')->where('status','=',1)->where('cus_id','=',$cus_id)->where('part_id','=',$part_id)->first();
                        $operation_id=22;
                        $operation_name='FG For Invoicing';
                        $operation='<option value="'.$operation_id.'" selected>'.$operation_name.'</option>';
                        $invoicemasterDatas=TransDataD11::with('rcmaster','partmaster')->where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select('rc_id','part_id',DB::raw('((receive_qty)-(issue_qty)) as avl_qty'))
                        ->havingRaw('avl_qty >?', [0])->get();
                        $count1=TransDataD11::where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as t_avl_qty'))
                        ->havingRaw('t_avl_qty >?', [0])->first();
                        $t_avl_qty=$count1->t_avl_qty;
                        // dd($count1);
                        $table="";
                        foreach ($invoicemasterDatas as $key => $dcmasterData) {
                            $table.='<tr>'.
                            // '<td><select name="route_part_id[]" class="form-control bg-light route_part_id" readonly id="route_part_id"><option value="'.$dcmasterData->partmaster->child_part_no.'">'.$dcmasterData->partmaster->child_part_no.'</option></select></td>'.
                            // '<td><input type="number" name="order_no[]"  class="form-control bg-light order_no" readonly  id="order_no" value="'.$dcmasterData->partmaster->no_item_id.'"></td>'.
                            // '<td><select name="route_card_id[]" class="form-control bg-light route_card_id" readonly id="route_card_id"><option value="'.$dcmasterData->rcmaster->id.'">'.$dcmasterData->rcmaster->rc_id.'</option></select></td>'.
                            // '<td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity" readonly  id="available_quantity" value="'.$dcmasterData->avl_qty.'"></td>'.
                            // '<td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity" readonly id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            // '<td><input type="number" name="balance[]"  class="form-control bg-light balance" readonly id="balance" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            // '</tr>';
                            '<td><select name="route_part_id[]" class="form-control bg-light route_part_id" id="route_part_id"><option value="'.$dcmasterData->partmaster->id.'">'.$dcmasterData->partmaster->child_part_no.'</option></select></td>'.
                            '<td><input type="number" name="order_no[]"  class="form-control bg-light order_no"  id="order_no" value="'.$dcmasterData->partmaster->no_item_id.'"></td>'.
                            '<td><select name="route_card_id[]" class="form-control bg-light route_card_id" id="route_card_id"><option value="'.$dcmasterData->rcmaster->id.'">'.$dcmasterData->rcmaster->rc_id.'</option></select></td>'.
                            '<td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity"  id="available_quantity" value="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity" id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="balance[]"  class="form-control bg-light balance" id="balance" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '</tr>';
                        }
                        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table,'operation'=>$operation,'regular'=>$check1,'alter'=>$check2,'bom'=>$bom,'cus_po_no'=>$cus_po_no]);
                    }else{
                        $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$cus_id)->where('part_id','=',$manufacturingPart)->first();
                        $operation_id=$dcmasterOperationDatas->operation_id;
                        $operation_name=$dcmasterOperationDatas->procesmaster->operation;
                        $operation='<option value="'.$operation_id.'" selected>'.$operation_name.'</option>';
                        $dcmasterDatas=TransDataD11::with('rcmaster')->where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select('rc_id',DB::raw('((receive_qty)-(issue_qty)) as avl_qty'))
                        ->havingRaw('avl_qty >?', [0])->get();
                        $count1=TransDataD11::where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as t_avl_qty'))
                        ->havingRaw('t_avl_qty >?', [0])->first();
                        $t_avl_qty=$count1->t_avl_qty;
                        // dd($dcmasterDatas);
                        $table="";
                        foreach ($dcmasterDatas as $key => $dcmasterData) {
                            $table.='<tr>'.
                            '<td><select name="route_card_id[]" class="form-control bg-light route_card_id" readonly id="route_card_id"><option value="'.$dcmasterData->rcmaster->id.'">'.$dcmasterData->rcmaster->child_part_no.'</option></select></td>'.
                            '<td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity" readonly  id="available_quantity" value="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity" readonly id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="balance[]"  class="form-control bg-light balance" readonly id="balance" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '</tr>';
                        }
                        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table,'operation'=>$operation,'regular'=>$check1,'alter'=>$check2]);
                    }
                }else{
                    // dd('not ok');
                    $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$cus_id)->where('part_id','=',$part_id)->first();
                    $operation_id=$dcmasterOperationDatas->operation_id;
                    $operation_name=$dcmasterOperationDatas->procesmaster->operation;
                    $operation='<option value="'.$operation_id.'" selected>'.$operation_name.'</option>';

                    $dcmasterDatas=DB::table('dc_masters as a')
                    ->join('product_masters AS b', 'a.part_id', '=', 'b.id')
                    ->join('child_product_masters AS c', 'c.part_id', '=', 'b.id')
                    ->join('trans_data_d11_s AS d', 'd.part_id', '=', 'c.id')
                    ->join('route_masters AS e', 'd.rc_id', '=', 'e.id')
                    ->select('e.id as rcId','e.rc_id','c.id as partId','c.child_part_no','c.no_item_id',DB::raw('((receive_qty)-(issue_qty)) as avl_qty'))
                    ->where('a.part_id','=',$part_id)
                    ->where('a.operation_id','=',$operation_id)
                    ->where('c.stocking_point','=',$operation_id)
                    ->where('d.next_process_id','=',$operation_id)
                    ->where('c.item_type','=',1)
                    ->havingRaw('avl_qty >?', [0])
                    ->orderBy('c.no_item_id', 'ASC')
                    ->orderBy('e.id', 'ASC')
                    ->get();
                    $dcmasterDatas2=DB::table('dc_masters as a')
                    ->join('product_masters AS b', 'a.part_id', '=', 'b.id')
                    ->join('child_product_masters AS c', 'c.part_id', '=', 'b.id')
                    ->join('trans_data_d11_s AS d', 'd.part_id', '=', 'c.id')
                    ->join('route_masters AS e', 'd.rc_id', '=', 'e.id')
                    ->select(DB::raw('((receive_qty)-(issue_qty)) as t_avl_qty'))
                    ->where('a.part_id','=',$part_id)
                    ->where('a.operation_id','=',$operation_id)
                    ->where('c.stocking_point','=',$operation_id)
                    ->where('d.next_process_id','=',$operation_id)
                    ->where('c.item_type','=',1)
                    ->havingRaw('t_avl_qty >?', [0])
                    ->orderBy('c.no_item_id', 'ASC')
                    ->orderBy('e.id', 'ASC')
                    ->min('t_avl_qty');
                    // dd($dcmasterDatas2);

                    $t_avl_qty=$dcmasterDatas2;

                    $table="";
                        foreach ($dcmasterDatas as $key => $dcmasterData) {
                            $table.='<tr class="order_'.$dcmasterData->no_item_id.'">'.
                            // '<td><select name="route_part_id[]" class="form-control bg-light route_part_id" readonly id="route_part_id"><option value="'.$dcmasterData->partId.'">'.$dcmasterData->child_part_no.'</option></select></td>'.
                            // '<td><input type="number" name="order_no[]"  class="form-control bg-light order_no" readonly  id="order_no" value="'.$dcmasterData->no_item_id.'"></td>'.
                            // '<td><select name="route_card_id[]" class="form-control bg-light route_card_id" readonly id="route_card_id"><option value="'.$dcmasterData->rcId.'">'.$dcmasterData->rc_id.'</option></select></td>'.
                            // '<td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity" readonly  id="available_quantity" value="'.$dcmasterData->avl_qty.'"></td>'.
                            // '<td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity" readonly id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            // '<td><input type="number" name="balance[]"  class="form-control bg-light balance" readonly id="balance" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            // '</tr>';
                            '<td><select name="route_part_id[]" class="form-control bg-light route_part_id"  id="route_part_id"><option value="'.$dcmasterData->partId.'">'.$dcmasterData->child_part_no.'</option></select></td>'.
                            '<td><input type="number" name="order_no[]"  class="form-control bg-light order_no"   id="order_no" value="'.$dcmasterData->no_item_id.'"></td>'.
                            '<td><select name="route_card_id[]" class="form-control bg-light route_card_id"  id="route_card_id"><option value="'.$dcmasterData->rcId.'">'.$dcmasterData->rc_id.'</option></select></td>'.
                            '<td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity"   id="available_quantity" value="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity"  id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '<td><input type="number" name="balance[]"  class="form-control bg-light balance"  id="balance" min="0" max="'.$dcmasterData->avl_qty.'"></td>'.
                            '</tr>';
                        }
                        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table,'operation'=>$operation,'regular'=>$check1,'alter'=>$check2,'bom'=>$bom]);
                }

        // $cus_order_datas;

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceDetailsRequest $request)
    {
        //
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceDetailsRequest $request, InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceDetails $invoiceDetails)
    {
        //
    }
}
