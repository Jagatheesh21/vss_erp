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
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\GRNInwardRegister;
use App\Models\GrnQuality;
use App\Models\HeatNumber;
use App\Models\StageQrCodeLock;
use App\Models\RMDc;
use App\Http\Requests\StoreRMDcRequest;
use App\Http\Requests\UpdateRMDcRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class RMDcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rmdcDatas=RMDc::with('dc_details','rm_details')->orderBy('id', 'ASC')->get();
        // dd($rmdcDatas);
        return view('dc.rc_dc_index',compact('rmdcDatas'));
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
            $str='00001';
            $new_rcnumber=$current_rcno.$str;
        }
        // dd($new_rcnumber);
            $dcmasterDatas=DcMaster::with('supplier')->where('status','=',1)->where('type_id','=',1)->groupBy('supplier_id')->get();
            // dd($dcmasterDatas);
            // return view('dc.create2',compact('dcmasterDatas','new_rcnumber','current_date'));
            return view('dc.rm_dc_create',compact('dcmasterDatas','new_rcnumber','current_date'));
            // return view('dc.index');
    }


    public function dcRmSupplierData(Request $request){
        // dd($request->supplier_id);
        $supplier_id=$request->supplier_id;
        // dd($supplier_id);
        $count=DcMaster::with('rmdetails')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('type_id','=',1)->get()->count();
        // dd($count);
        if ($count > 0) {
            $dcmasterDatas=DcMaster::with('rmdetails')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('type_id','=',1)->get();
            $rm_id='<option value="" selected>Select The RM</option>';
            foreach ($dcmasterDatas as $key => $dcmasterData) {
                $rm_id.='<option value="'.$dcmasterData->rmdetails->id.'">'.$dcmasterData->rmdetails->name.'</option>';
            }
        return response()->json(['count'=>$count,'rm_id'=>$rm_id]);
        }else{
            return response()->json(['count'=>$count]);
        }
    }

    public function dcrmGrnData(Request $request){
        // dd($request->all());
        $supplier_id=$request->supplier_id;
        $rm_id=$request->rm_id;
        $count=DB::table('g_r_n_inward_registers as a')
        ->join('p_o_product_details AS b', 'a.p_o_product_id', '=', 'b.id')
        ->join('supplier_products as c', 'b.supplier_product_id', '=', 'c.id')
        ->join('raw_materials as d', 'c.raw_material_id', '=', 'd.id')
        ->join('route_masters as k','k.id','=','a.grnnumber')
        ->select('a.id','a.avl_qty','k.rc_id')
        ->where('a.status','=',0)
        ->where('d.id','=',$rm_id)
        ->havingRaw('a.avl_qty >?', [0])
        ->orderBy('a.id', 'ASC')
        ->count();

        if ($count>0) {
            $dcmasterDatas=DcMaster::with('procesmaster')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('rm_id','=',$rm_id)->where('type_id','=',1)->get();
            $operation_id='<option value="" selected>Select Operation</option>';
            foreach ($dcmasterDatas as $key => $dcmasterData) {
                $operation_id.='<option value="'.$dcmasterData->procesmaster->id.'" selected>'.$dcmasterData->procesmaster->operation.'</option>';
            }
            $grndatas=DB::table('g_r_n_inward_registers as a')
            ->join('p_o_product_details AS b', 'a.p_o_product_id', '=', 'b.id')
            ->join('supplier_products as c', 'b.supplier_product_id', '=', 'c.id')
            ->join('raw_materials as d', 'c.raw_material_id', '=', 'd.id')
            ->join('route_masters as k','k.id','=','a.grnnumber')
            ->select('a.id as grn_id','a.avl_qty','k.rc_id')
            ->where('a.status','=',0)
            ->where('d.id','=',$rm_id)
            ->havingRaw('a.avl_qty >?', [0])
            ->orderBy('a.id', 'ASC')
            ->get();
            $grn_id='<option value="" selected>Select The GRN Number</option>';
            foreach ($grndatas as $key => $grndata) {
                $grn_id.='<option value="'.$grndata->grn_id.'">'.$grndata->rc_id.'</option>';
            }
        return response()->json(['count'=>$count,'grn_id'=>$grn_id,'operation'=>$operation_id]);
        }else{
            return response()->json(['count'=>$count]);
        }
    }

    public function dcrmGrnCoilData(Request $request){
        // dd($request->all());
        $supplier_id=$request->supplier_id;
        $rm_id=$request->rm_id;
        $grn_id=$request->grn_id;
        $grndatas=GRNInwardRegister::with('rcmaster')->find($grn_id);
        $grn_avl_kg=$grndatas->avl_qty;
        $count=GrnQuality::with('heat_no_data')->where('grnnumber_id','=',$grn_id)->where('status','=',1)->get()->count();
        if($count>0){
            $grnQcDatas=GrnQuality::with('heat_no_data')->where('grnnumber_id','=',$grn_id)->where('status','=',1)->get();
            $html=view('dc.rm_dc_qtypick',compact('grnQcDatas','grn_id'))->render();
        }
        return response()->json(['grn_avl_kg'=>$grn_avl_kg,'html'=>$html]);

        // dd($grn_avl_kg);

    }

    // public function dcrmGrnCoilQtyData(Request $request){
    //     $supplier_id=$request->supplier_id;
    //     $rm_id=$request->rm_id;
    //     $grn_id=$request->grn_id;
    //     $dc_qty=$request->dc_qty;

    //     return response()->json(['html'=>$html]);

    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRMDcRequest $request)
    {
        //
        // dd($request->all());
        $dc_number=$request->dc_number;
        $dc_date=$request->dc_date;
        $supplier_id=$request->supplier_id;
        $rm_id=$request->rm_id;
        $grn_id=$request->grn_id;
        $operation_id=$request->operation_id;
        $avl_quantity=$request->avl_quantity;
        $dc_quantity=$request->dc_quantity;
        $trans_mode=$request->trans_mode;
        $vehicle_no=$request->vehicle_no??NULL;
        $remarks=$request->remarks;
        $heat_id=$request->heat_id;
        $coil_no=$request->coil_no;
        $lot_no=$request->lot_no;
        $tc_no=$request->tc_no;
        $available_quantity=$request->available_quantity;
        $issue_quantity=$request->issue_quantity;
        $balance=$request->balance;

        $dcMasterData=DcMaster::with('procesmaster','supplier')->where('rm_id','=',$rm_id)->where('operation_id','=',$operation_id)->where('supplier_id','=',$supplier_id)->first();
        $valuation_rate=(($dcMasterData->procesmaster->valuation_rate)/100);
        $dcMaster_id=$dcMasterData->id;

        $grnDatas=GRNInwardRegister::with('poproduct')->find($grn_id);
        $unit_rate=$grnDatas->poproduct->rate;
        $uom_id=$grnDatas->poproduct->uom_id;

        $basic_value=$dc_quantity*$unit_rate;

        $rcMaster=new RouteMaster;
        $rcMaster->create_date=$dc_date;
        $rcMaster->process_id=$operation_id;
        $rcMaster->rc_id=$dc_number;
        $rcMaster->prepared_by=auth()->user()->id;
        $rcMaster->save();

        $rcMasterData=RouteMaster::where('rc_id','=',$dc_number)->where('process_id','=',$operation_id)->first();
        $rc_id=$rcMasterData->id;

        $dcTransData=new DcTransactionDetails;
        $dcTransData->rc_id=$rc_id;
        $dcTransData->issue_date=$dc_date;
        $dcTransData->dc_master_id=$dcMaster_id;
        $dcTransData->issue_qty=$dc_quantity;
        $dcTransData->unit_rate=$unit_rate;
        $dcTransData->basic_rate=$basic_value;
        $dcTransData->total_rate=$basic_value;
        $dcTransData->issue_wt=$dc_quantity;
        $dcTransData->trans_mode=$trans_mode;
        $dcTransData->vehicle_no=$vehicle_no;
        $dcTransData->uom_id=$uom_id;
        $dcTransData->remarks=$remarks;
        $dcTransData->prepared_by = auth()->user()->id;
        $dcTransData->save();

        $dc_id=$dcTransData->id;

        $dcPrintData=new DcPrint;
        $dcPrintData->s_no=0;
        $dcPrintData->dc_id=$dc_id;
        $dcPrintData->from_unit=1;
        $dcPrintData->print_status=0;
        $dcPrintData->prepared_by = auth()->user()->id;
        $dcPrintData->save();

        $rmDc=new RMDc;
        $rmDc->rm_id=$rm_id;
        $rmDc->dc_id=$dc_id;
        $rmDc->print_status=0;
        $rmDc->prepared_by = auth()->user()->id;
        $rmDc->save();

        $grn=GRNInwardRegister::with('poproduct')->find($grn_id);
        $old_return_dc_qty=$grn->return_dc_qty;
        $old_avl_qty=$grn->avl_qty;
        $return_dc_qty=$old_return_dc_qty+$dc_quantity;
        $avl_qty=$old_avl_qty-$dc_quantity;
        $grn->return_dc_qty=$return_dc_qty;
        $grn->avl_qty=$avl_qty;
        $grn->updated_by = auth()->user()->id;
        $grn->updated_at = Carbon::now();
        $grn->update();

        $grn2=GRNInwardRegister::with('poproduct')->find($grn_id);
        $grn_rmavl_qty=$grn2->avl_qty;
        if ($grn_rmavl_qty<1) {
            $grn2->status =1;
        }
        $grn2->updated_by = auth()->user()->id;
        $grn2->updated_at = Carbon::now();
        $grn2->update();

        foreach ($issue_quantity as $key => $value) {
            if ($value!=0) {
                $grnQcDatas=GrnQuality::where('grnnumber_id','=',$grn_id)->where('heat_no_id','=',$heat_id[$key])->first();
                $old_rm_issue_qty=$grnQcDatas->issue_qty;
                $rm_issue_qty=(($old_rm_issue_qty)+($value));
                $grnQcDatas->issue_qty=$rm_issue_qty;
                $grnQcDatas->updated_by = auth()->user()->id;
                $grnQcDatas->updated_at = Carbon::now();
                $grnQcDatas->update();

                $grnQcDatas2=GrnQuality::where('grnnumber_id','=',$grn_id)->where('heat_no_id','=',$heat_id[$key])->first();
                $rm_avl_qty=(($grnQcDatas2->approved_qty)-($grnQcDatas2->issue_qty));
                if ($rm_avl_qty<1) {
                    $grnQcDatas->status =0;
                }
                $grnQcDatas2->updated_by = auth()->user()->id;
                $grnQcDatas2->updated_at = Carbon::now();
                $grnQcDatas2->update();
            }
        }
        return redirect()->route('rmdc.index')->withSuccess('RM Delivery Challan Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RMDc $rmdc)
    {
        //
    }

    public function rmdcReceiveData(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $receiveRmDCDatas=RMDc::with('dc_details','rm_details')->where('status','=',1)->orderBy('id', 'ASC')->get();

        $d11Datas=TransDataD11::where('next_process_id','=',21)->where('status','=',1)->get();
        $activity='RM DC Receive';
        $stage='Store';
        $qrCodes_count=StageQrCodeLock::where('stage','=',$stage)->where('activity','=',$activity)->where('status','=',1)->count();
        return view('stagewise-receive.rm_dc_receive',compact('receiveRmDCDatas','d11Datas','current_date','qrCodes_count'));
    }

    public function rmdcReceiveRcData(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;
        $value=$rc_no;
        $rm_count=RMDc::with('dc_details','rm_details')->WhereHas('dc_details', function ($q) use ($value) {
            $q->where('rc_id', '=', $value);
        })->count();
        if ($rm_count>0) {
            $rmRcDatas=RMDc::with('dc_details','rm_details')->WhereHas('dc_details', function ($q) use ($value) {
                $q->where('rc_id', '=', $value);
            })->first();
            $rm_id='<option value="'.$rmRcDatas->rm_details->id.'">'.$rmRcDatas->rm_details->name.'</option>';
            $rm_avl_qty=(($rmRcDatas->dc_details->issue_qty)-($rmRcDatas->dc_details->receive_qty));
            $value2=$rmRcDatas->dc_details->dcmaster->operation_id;
            $part_count=BomMaster::with('childpart_master')->WhereHas('childpart_master', function ($q2) use ($value2) {
                $q2->where('stocking_point', '=', $value2);
            })->where('rm_id','=',$rmRcDatas->rm_details->id)->where('status','=',1)->count();
            if ($part_count>0) {
                $partDatas=BomMaster::with('childpart_master')->WhereHas('childpart_master', function ($q2) use ($value2) {
                    $q2->where('stocking_point', '=', $value2);
                })->where('rm_id','=',$rmRcDatas->rm_details->id)->where('status','=',1)->get();
                $part_id='<option value="" selected>Select The Part Number</option>';
                foreach ($partDatas as $key => $partData) {
                    $part_id.='<option value="'.$partData->childpart_master->id.'">'.$partData->childpart_master->child_part_no.'</option>';
                }
                $operation_id=21;
                $operation_name='From S/C';
                $operation='<option value="'.$operation_id.'" selected>'.$operation_name.'</option>';

            } else {
                $part_id='<option value="" Selected>No Part Number Available</option>';
            $operation='<option value="" Selected>No Operation</option>';

            }
        }else{
            $rm_id='<option value="" Selected>No RM Available</option>';
            $part_count=0;
            $rm_avl_qty=0;
            $part_id='<option value="" Selected>No Part Number Available</option>';
            $operation='<option value="" Selected>No Operation</option>';
        }
        // dd($partDatas);
        // dd($rmRcDatas);
        return response()->json(['rm_count'=>$rm_count,'part_count'=>$part_count,'rm_id'=>$rm_id,'part_id'=>$part_id,'rm_avl_qty'=>$rm_avl_qty,'operation'=>$operation]);

    }
    public function rmdcReceivePartData(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;
        $rm_id=$request->rm_id;
        $part_id=$request->part_id;
        $avl_kg=$request->avl_kg;
        $value2=17;
        $count=BomMaster::with('childpart_master')->WhereHas('childpart_master', function ($q2) use ($value2) {
            $q2->where('stocking_point', '=', $value2);
        })->where('rm_id','=',$rm_id)->where('status','=',1)->where('child_part_id','=',$part_id)->count();
        if ($count>0) {
            $bomDatas=BomMaster::with('childpart_master')->WhereHas('childpart_master', function ($q2) use ($value2) {
                $q2->where('stocking_point', '=', $value2);
            })->where('rm_id','=',$rm_id)->where('status','=',1)->where('child_part_id','=',$part_id)->first();
            $bom=$bomDatas->input_usage;
            $avl_qty=floor(($avl_kg/$bom));
        } else {
            $bom=0;
            $avl_qty=0;
        }
        // dd($avl_qty);
        // dd($bomDatas);
        return response()->json(['bom'=>$bom,'avl_qty'=>$avl_qty]);
    }

    public function rmdcReceiveStore(Request $request){
        dd($request->all());

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RMDc $rmdc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRMDcRequest $request, RMDc $rmdc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RMDc $rmdc)
    {
        //
    }
}
