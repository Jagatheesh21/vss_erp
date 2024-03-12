<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
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
use App\Http\Requests\StoreDcTransactionDetailsRequest;
use App\Http\Requests\UpdateDcTransactionDetailsRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class DcTransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');
        if ( date('m') > 3 ) {
            $year = date('y');
            $next_year=date('y')+1;
            $finacial_year=$year."-".$next_year;
        }
        else {
            $year = date('y') - 1;
            $next_year=date('y');
            $finacial_year=$year."-".$next_year;
        }
        // dd($finacial_year);
            $rc="DC-U1D";
		$current_rcno=$rc.$finacial_year;
        $count1=RouteMaster::whereIn('process_id',[16,17])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        if ($count1 > 0) {
            $rc_data=RouteMaster::whereIn('process_id',[16,17])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $rcnumber=$rc_data['rc_id']??NULL;
            $old_rcnumber=str_replace($current_rcno,"",$rcnumber);
            $old_rcnumber_data=str_pad($old_rcnumber+1,5,0,STR_PAD_LEFT);
            $new_rcnumber=$current_rcno.$old_rcnumber_data;
        }else{
            $str='000001';
            $new_rcnumber=$current_rcno.$str;
        }
        // dd($new_rcnumber);
            $dcmasterDatas=DcMaster::with('supplier')->where('status','=',1)->groupBy('supplier_id')->get();
            // dd($dcmasterDatas);
            // return view('dc.create2',compact('dcmasterDatas','new_rcnumber','current_date'));
            return view('dc.insert',compact('dcmasterDatas','new_rcnumber','current_date'));
            // return view('dc.index');
    }

    public function dcPartData(Request $request){
        // dd($request->supplier_id);
        $supplier_id=$request->supplier_id;
        // dd($supplier_id);
        $count=DcMaster::with('invoicepart')->where('status','=',1)->where('supplier_id','=',$supplier_id)->get()->count();
        // dd($count);
        if ($count > 0) {
            $dcmasterDatas=DcMaster::with('invoicepart')->where('status','=',1)->where('supplier_id','=',$supplier_id)->get();
            $part_id='<option value="" selected>Select The Part Number</option>';
            foreach ($dcmasterDatas as $key => $dcmasterData) {
                $part_id.='<option value="'.$dcmasterData->invoicepart->id.'">'.$dcmasterData->invoicepart->part_no.'</option>';
            }
        return response()->json(['count'=>$count,'part_id'=>$part_id]);
        }else{
            return response()->json(['count'=>$count]);
        }
    }

    public function dcItemRc(Request $request){
        // dd($request->all());
        $part_id=$request->part_id;
        $supplier_id=$request->supplier_id;
        $check=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->count();
        $check1=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->where('item_type','=',1)->count();
        $check2=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->where('item_type','=',0)->count();
        $manufacturingPartDatas=ChildProductMaster::where('status','=',1)->where('part_id','=',$part_id)->get();
                if ($check1==1) {
                    foreach ($manufacturingPartDatas as $key => $manufacturingPartData) {
                        $manufacturingPart=$manufacturingPartData->id;
                        $itemType=$manufacturingPartData->item_type;
                    }
                    if ($itemType==1) {
                        $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('part_id','=',$manufacturingPart)->first();
                        $operation_id=$dcmasterOperationDatas->operation_id;
                        $operation_name=$dcmasterOperationDatas->procesmaster->operation;
                        $operation='<option value="'.$operation_id.'" selected>'.$operation_name.'</option>';
                        $dcmasterDatas=TransDataD11::with('rcmaster','partmaster')->where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select('rc_id','part_id',DB::raw('((receive_qty)-(issue_qty)) as avl_qty'))
                        ->havingRaw('avl_qty >?', [0])->get();
                        $count1=TransDataD11::where('next_process_id','=',$operation_id)->where('part_id','=',$manufacturingPart)->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as t_avl_qty'))
                        ->havingRaw('t_avl_qty >?', [0])->first();
                        $t_avl_qty=$count1->t_avl_qty;
                        // dd($dcmasterDatas);
                        $table="";
                        foreach ($dcmasterDatas as $key => $dcmasterData) {
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
                        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table,'operation'=>$operation,'regular'=>$check1,'alter'=>$check2]);
                    }else{
                        $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('part_id','=',$manufacturingPart)->first();
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
                    $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('part_id','=',$part_id)->first();
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
                        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table,'operation'=>$operation,'regular'=>$check1,'alter'=>$check2]);
                }

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcTransactionDetailsRequest $request)
    {
        //
        dd($request->all());
        $dc_number=$request->dc_number;
        $dc_date=$request->dc_date;
        $supplier_id=$request->supplier_id;
        $part_id=$request->part_id;
        $operation_id=$request->operation_id;
        $dc_avl_quantity=$request->avl_quantity;
        $dc_quantity=$request->dc_quantity;
        $trans_mode=$request->trans_mode;
        $vehicle_no=$request->vehicle_no;
        $regular=$request->regular;
        $alter=$request->alter;
        $route_part_id=$request->route_part_id;
        $order_no=$request->order_no;
        $route_card_id=$request->route_card_id;
        $rc_available_quantity=$request->available_quantity;
        $rc_issue_quantity=$request->issue_quantity;
        $dcMasterData=DcMaster::with('procesmaster','supplier')->where('part_id','=',$part_id)->where('operation_id','=',$operation_id)->where('supplier_id','=',$supplier_id)->first();
        $valuation_rate=$dcMasterData->procesmaster->valuation_rate;
        $customerProductData=CustomerProductMaster::where('part_id','=',$part_id)->where('status','=',1)->sum('part_rate');
        $part_rate=$customerProductData->part_rate;
        $unit_rate=$part_rate*$valuation_rate;

        $rcMaster=new RouteMaster;
        $rcMaster->create_date=$dc_date;
        $rcMaster->process_id=$operation_id;
        $rcMaster->rc_id=$dc_number;
        $rcMaster->prepared_by=auth()->user()->id;
        $rcMaster->save();

        $rcMasterData=RouteMaster::where('rc_id','=',$dc_number)->where('process_id','=',$operation_id)->first();
        $rc_id=$rcMasterData->id;

        if ($regular==1) {
            foreach ($route_card_id as $key => $card_id) {
                $previousD11Datas=TransDataD11::where('rc_id','=',$card_id)->where('next_process_id','=',$operation_id)->first();
                // dd($previousD11Datas);
                $old_issueqty=$previousD11Datas->issue_qty;
                $total_issue_qty=$old_issueqty+$request->issue_quantity[$key];
                $previousD11Datas->issue_qty=$total_issue_qty;
                $previousD11Datas->updated_by = auth()->user()->id;
                $previousD11Datas->updated_at = Carbon::now();
                $previousD11Datas->update();

                $currentProcess=ProductProcessMaster::where('part_id','=',$part_id)->where('process_master_id','=',$operation_id)->first();
                $current_order=$currentProcess->process_order_id;

                $d11Datas=new TransDataD11;
                $d11Datas->open_date=$dc_date;
                $d11Datas->rc_id=$rc_id;
                $d11Datas->part_id=$request->part_id;
                $d11Datas->process_id=$request->previous_process_id;
                $d11Datas->product_process_id=$request->previous_product_process_id;
                $d11Datas->next_process_id=$request->next_process_id;
                $d11Datas->next_product_process_id=$request->next_product_process_id;
                $d11Datas->process_issue_qty=$request->issue_qty;
                $d11Datas->prepared_by = auth()->user()->id;
                $d11Datas->save();
            }


        }elseif ($regular>1) {
            # code...
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDcTransactionDetailsRequest $request, DcTransactionDetails $dcTransactionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DcTransactionDetails $dcTransactionDetails)
    {
        //
    }
}
