<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
use App\Models\BomMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\ProductProcessMaster;
use App\Models\ChildProductMaster;
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DcPrint;
use App\Http\Requests\StoreDcPrintRequest;
use App\Http\Requests\UpdateDcPrintRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

use function Laravel\Prompts\select;

class DcPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dcprintDatas=DcPrint::with('dctransaction')->where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','!=',0)->groupBy('s_no') ->get();
        return view('dc_print.index',compact('dcprintDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dcprintSnos=DcPrint::with('dctransaction')->where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','!=',0) ->select('s_no')->orderBy('id','DESC')->first();
        $dcsupplierDatas=DcMaster::with('supplier')->where('status','=',1)->get();
        $sno=$dcprintSnos->s_no??NULL;
        // dd($sno);
        $dc_sno=$sno+1;
        // dd($dc_sno);
        return view('dc_print.create',compact('dcsupplierDatas','dc_sno'));
    }



    public function dcMultiPrintData(Request $request){
        // dd($request->all());
        $s_no=$request->s_no;
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.s_no','=',$s_no)
        ->get();
        // dd($dc_transactionDatas);

        $table="";
        foreach ($dc_transactionDatas as $key => $dc_transactionData) {
            $table.='<tr class="tr_'.$dc_transactionData->dc_print_id.'">'.
            '<td>'.$dc_transactionData->dc_no.'</td>'.
            '<td>'.$dc_transactionData->issue_date.'</td>'.
            '<td>'.$dc_transactionData->part_no.'</td>'.
            '<td>'.$dc_transactionData->issue_qty.'</td>'.
            '<td>'.$dc_transactionData->uom.'</td>'.
            '<td>'.$dc_transactionData->unit_rate.'</td>'.
            '<td>'.$dc_transactionData->total_rate.'</td>'.
            '</tr>';
        }
        return response()->json(['table'=>$table]);

    }

    public function ptsdcMultiReceiveData(Request $request){
        // dd($request->all());
        $s_no=$request->s_no;
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate',DB::raw('((b.issue_qty)-(b.receive_qty)) as avl_qty'))
        ->where('a.s_no','=',$s_no)
        ->havingRaw('avl_qty >?', [0])
        ->get();
        // dd($dc_transactionDatas);
        $html = view('dc_print.add_items',compact('dc_transactionDatas'))->render();
        return response()->json(['table'=>$html]);
    }

    public function dcMultiPdfData(Request $request){
        $s_no=$request->s_no;
        $count=DcPrint::where('s_no','=',$s_no)->count();
        $page_count=$count/10;
        // dd($page_count);
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->join('item_procesmasters as g', 'c.operation_id', '=', 'g.id')
        ->join('suppliers as h', 'c.supplier_id', '=', 'h.id')
        ->select('c.operation_desc','c.hsnc','b.vehicle_no','b.trans_mode','a.id as dc_print_id','h.name as supplier_name','h.address as supplier_address','h.address1 as supplier_address1','h.city as supplier_city','h.state as supplier_state','h.pincode as supplier_pincode','h.state_code as supplier_state_code','h.gst_number as supplier_gst_number','a.s_no','b.issue_wt','c.operation_id','g.operation','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.s_no','=',$s_no)
        ->get();
        $totalData=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')->where('a.s_no','=',$s_no)->select(DB::raw('(SUM(total_rate)) as sum_rate'),DB::raw('(SUM(issue_qty)) as sum_qty'))->get();
        // dd($dc_transactionDatas);
        $pdf = Pdf::loadView('dc_print.dcmultipdf',compact('dc_transactionDatas','totalData','count','page_count'))->setPaper('a4', 'portrait');
        // $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream();
        // return view('dc_print.dcmultipdf',compact('dc_transactionDatas'));
    }
    public function dcSupplierPrintData(Request $request){
        // dd($request->all());
        $supplier_id=$request->supplier_id;
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.print_status','=',0)
        ->where('a.s_no','=',0)
        ->where('c.supplier_id','=',$supplier_id)
        ->get();
        // dd($dc_transactionDatas);

        $table="";
        foreach ($dc_transactionDatas as $key => $dc_transactionData) {
            $table.='<tr class="tr_'.$dc_transactionData->dc_print_id.'">'.
            '<td><input type="checkbox" class="form-check-input sub_id" name="sub_id[]" data-id="'.$dc_transactionData->dc_print_id.'" value="'.$dc_transactionData->dc_print_id.'"></td>'.
            '<td><select name="dc_id[]" class="form-control bg-light dc_id" readonly id="dc_id"><option value="'.$dc_transactionData->dc_id.'">'.$dc_transactionData->dc_no.'</option></select></td>'.
            '<td><input type="date" name="issue_date[]"  class="form-control bg-light issue_date" readonly  id="issue_date" value="'.$dc_transactionData->issue_date.'"></td>'.
            '<td><select name="part_id[]" class="form-control bg-light part_id" readonly id="part_id"><option value="'.$dc_transactionData->part_id.'">'.$dc_transactionData->part_no.'</option></select></td>'.
            '<td><input type="number" name="issue_qty[]"  class="form-control bg-light issue_qty" readonly  id="issue_qty" value="'.$dc_transactionData->issue_qty.'"></td>'.
            '<td><select name="uom_id[]" class="form-control bg-light uom_id"  id="uom_id"><option value="'.$dc_transactionData->uom_id.'">'.$dc_transactionData->uom.'</option></select></td>'.
            '<td><input type="number" name="unit_rate[]" readonly class="form-control bg-light unit_rate"   id="unit_rate" value="'.$dc_transactionData->unit_rate.'"></td>'.
            '<td><input type="number" name="total_rate[]" readonly  class="form-control bg-light total_rate"   id="total_rate" value="'.$dc_transactionData->total_rate.'"></td>'.
            '</tr>';
        }
        return response()->json(['table'=>$table]);

    }

    public function ptsdcMultiList(){
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.receive_qty','b.issue_qty','b.reason','b.remarks',DB::raw('((b.issue_qty)-(b.receive_qty)) as avl_qty'))
        ->where('b.receive_qty','!=',0)
        ->get();
        dd($dc_transactionDatas);
    }

    public function ptsInwardData(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->join('route_masters AS e', 'a.rc_id', '=', 'e.id')
        ->join('route_masters AS f', 'a.previous_rc_id', '=', 'f.id')
        ->select('b.operation','b.id as process_id','a.open_date','e.rc_id','f.rc_id as previous_rc_id','a.issue_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('a.process_id', [18])
        ->whereRaw('a.rc_id!=a.previous_rc_id')
        ->orderBy('a.id', 'DESC')
        ->get();
    //    dd($d12Datas);
       return view('dc_print.pts_inwardlist',compact('d12Datas'));
    }

    public function ptsMultiDcStore(Request $request){
        // dd($request->all());
        $s_no=$request->s_no;
        $dcprint_datas=$request->sub_id;
        $dc_id=$request->dc_id;
        $issue_date=$request->issue_date;
        $part_id=$request->part_id;
        $issue_qty=$request->issue_qty;
        $receive_qty=$request->receive_qty;
        $balance_qty=$request->balance_qty;
        $receive_qty=$request->receive_qty;

        foreach ($dcprint_datas as $key => $dcprint_data) {
            // dump($key);
            // dump($dcprint_data);
            // dump($balance_qty[$dcprint_data]);

            if ($dcprint_data!='') {
                // no mismatch in inward quantity query
                    if ($balance_qty[$dcprint_data]==0) {
                        // update dc print
                        $dcPrintDatas=DcPrint::find($dcprint_data);
                        $dcPrintDatas->status=0;
                        $dcPrintDatas->updated_by = auth()->user()->id;
                        $dcPrintDatas->update();

                        // update dc transaction
                        $dcTransactionData=DcTransactionDetails::find($dc_id[$dcprint_data]);
                        $old_dcreceive_qty=(($dcTransactionData->receive_qty)+($receive_qty[$dcprint_data]));
                        $dcTransactionData->receive_qty=$old_dcreceive_qty;
                        $dcTransactionData->status=0;
                        $dcTransactionData->rc_status=0;
                        $dcTransactionData->updated_by = auth()->user()->id;
                        $dcTransactionData->update();

                        // update dc receive qty
                        $rc_id=$dcTransactionData->rc_id;
                        $preTransDataD11Datas=TransDataD11::where('rc_id','=',$rc_id)->first();
                        $old_receive_qty=$preTransDataD11Datas->receive_qty;
                        $old_issue_qty=$preTransDataD11Datas->issue_qty;
                        $total_receive=(($old_receive_qty)+($receive_qty[$dcprint_data]));
                        $total_issue=(($old_issue_qty)+($issue_qty[$dcprint_data]));
                        $current_process_id=$preTransDataD11Datas->next_process_id;
                        $current_product_process_id=$preTransDataD11Datas->next_product_process_id;
                        $preTransDataD11Datas->receive_qty=$total_receive;
                        $preTransDataD11Datas->updated_by = auth()->user()->id;
                        $preTransDataD11Datas->update();

                        // check dc master data
                        $dc_master_id=$dcTransactionData->dc_master_id;
                        $dcMasterData=DcMaster::find($dc_master_id);
                        $operation_id=$dcMasterData->operation_id;
                        $part_id=$dcMasterData->part_id;

                        $current_processDatas=ProductProcessMaster::where('part_id','=',$part_id)->where('process_master_id','=',$current_process_id)->where('id','=',$current_product_process_id)->first();
                        $current_process_order_id=$current_processDatas->process_order_id;

                        $next_processDatas=ProductProcessMaster::where('part_id','=',$part_id)->where('process_order_id','>',$current_process_order_id)->where('status','=',1)->first();
                        $next_product_process_id=$next_processDatas->id;
                        $next_process_id=$next_processDatas->process_master_id;
                        $next_process_order_id=$next_processDatas->process_order_id;
                        // dd($next_process_id);

                        date_default_timezone_set('Asia/Kolkata');
                        $current_date=date('Y-m-d');
                        $current_year=date('Y');
                        if ($current_process_id==18) {
                            $rc="Q";
                        }elseif ($current_process_id==19) {
                            $rc="L";
                        }
                        $current_rcno=$rc.$current_year;
                        $count1=RouteMaster::where('process_id',$current_process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
                        // $count=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->get()->count();
                        if ($count1 > 0) {
                            // $rc_data=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->first();
                            $rc_data=RouteMaster::where('process_id',$current_process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
                            $rcnumber=$rc_data['rc_id']??NULL;
                            if ($current_process_id==18) {
                                $old_rcnumber=str_replace("Q","",$rcnumber);
                            }elseif ($current_process_id==19) {
                                $old_rcnumber=str_replace("L","",$rcnumber);
                            }
                            $old_rcnumber_data=str_pad($old_rcnumber+1,9,0,STR_PAD_LEFT);
                            if ($current_process_id==18) {
                                $new_rcnumber='Q'.$old_rcnumber_data;
                            }elseif ($current_process_id==19) {
                                $new_rcnumber='L'.$old_rcnumber_data;
                            }
                        }else{
                            $str='000001';
                            $new_rcnumber=$current_rcno.$str;
                        }
                        // dd($new_rcnumber);

                        // new route card master
                        $rcMaster=new RouteMaster;
                        $rcMaster->create_date=$current_date;
                        $rcMaster->process_id=$current_process_id;
                        $rcMaster->rc_id=$new_rcnumber;
                        $rcMaster->prepared_by=auth()->user()->id;
                        $rcMaster->save();

                        $new_rc_id=$rcMaster->id;

                        //  new d11 transaction datas
                        $next_processDatas2=ProductProcessMaster::where('part_id','=',$part_id)->where('process_order_id','>',$next_process_order_id)->where('status','=',1)->first();
                        $next_product_process_id2=$next_processDatas2->id;
                        $next_process_id2=$next_processDatas2->process_master_id;
                        $next_process_order_id2=$next_processDatas2->process_order_id;

                            $newTransDataD11Datas=new TransDataD11;
                            $newTransDataD11Datas->open_date=$current_date;
                            $newTransDataD11Datas->rc_id=$new_rc_id;
                            $newTransDataD11Datas->part_id=$part_id;
                            $newTransDataD11Datas->process_id=$current_process_id;
                            $newTransDataD11Datas->product_process_id=$current_product_process_id;
                            $newTransDataD11Datas->next_process_id=$next_process_id;
                            $newTransDataD11Datas->next_product_process_id=$next_process_order_id;
                            $newTransDataD11Datas->process_issue_qty=$receive_qty[$dcprint_data];
                            $newTransDataD11Datas->prepared_by = auth()->user()->id;
                            $newTransDataD11Datas->save();

                            $d12Datas=new TransDataD12;
                            $d12Datas->open_date=$current_date;
                            $d12Datas->rc_id=$new_rc_id;
                            $d12Datas->previous_rc_id=$rc_id;
                            $d12Datas->part_id=$part_id;
                            $d12Datas->process_id=$current_process_id;
                            $d12Datas->product_process_id=$current_product_process_id;
                            $d12Datas->issue_qty=$receive_qty[$dcprint_data];
                            $d12Datas->prepared_by = auth()->user()->id;
                            $d12Datas->save();

                            $d13Datas=new TransDataD13;
                            $d13Datas->rc_id=$new_rc_id;
                            $d13Datas->previous_rc_id=$rc_id;
                            $d13Datas->prepared_by = auth()->user()->id;
                            $d13Datas->save();
                            DB::commit();
                    }
            }
        }
        return redirect()->route('ptsmultidcreceive')->withSuccess('Multi Delivery Challan Part Received Successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcPrintRequest $request)
    {
        //
        // dd($request->all());
        $sub_datas=$request->sub_id;
        foreach ($sub_datas as $key => $sub_data) {
            $dcprintDatas=DcPrint::find($sub_data);
            $dcprintDatas->s_no=$request->s_no;
            $dcprintDatas->print_status=1;
            $dcprintDatas->updated_by = auth()->user()->id;
            $dcprintDatas->update();
            DB::commit();
        }
        return redirect()->route('dcprint.index')->withSuccess('Multi Delivery Challan Created Successfully!');
    }

    public function ptsMultiDCReceive()
    {
        $multiDCDatas=DcPrint::where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','=',1)->where('status','=',1)->groupBy('s_no') ->get();
        // dd($multiDCDatas);
        return view('dc_print.pts_multidc_receive',compact('multiDCDatas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DcPrint $dcprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DcPrint $dcprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDcPrintRequest $request, DcPrint $dcprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DcPrint $dcprint)
    {
        //
    }
}
