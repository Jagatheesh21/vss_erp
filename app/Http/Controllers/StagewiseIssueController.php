<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\RawMaterial;
use App\Models\Rackmaster;
use App\Models\ModeOfUnit;
use App\Models\GRNInwardRegister;
use App\Models\GrnQuality;
use App\Models\PODetail;
use App\Models\POProductDetail;
use App\Models\ProductProcessMaster;
use App\Models\HeatNumber;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\BomMaster;
use App\Models\ItemProcesmaster;
use App\Models\ChildProductMaster;
use App\Models\RouteMaster;
use App\Models\StageQrCodeLock;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class StagewiseIssueController extends Controller
{
    //Semi Finished Issue Entry Start
    public function sfIssueList(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->join('route_masters AS e', 'a.rc_id', '=', 'e.id')
        ->join('route_masters AS f', 'a.previous_rc_id', '=', 'f.id')
        ->select('b.operation','b.id as process_id','a.open_date','e.rc_id','f.rc_id as previous_rc_id','a.issue_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('a.process_id', [6,7,8])
        ->whereRaw('a.rc_id!=a.previous_rc_id')
        ->orderBy('a.id', 'DESC')
        ->get();
    //    dd($d12Datas);
       return view('stagewise-issue.sf_view',compact('d12Datas'));
    }

    public function sfIssueCreateForm(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas  = DB::table('trans_data_d11_s as a')
            ->join('route_masters AS e', 'a.rc_id', '=', 'e.id')
            ->select('e.rc_id as rc_no','e.id',DB::raw('((a.receive_qty)-(a.issue_qty)) as avl_qty'))
            ->whereIn('a.next_process_id', [6,7,8])
            ->havingRaw('avl_qty >?', [0])
            ->get();
    // dd($d11Datas);
        $activity='SF Issuance';
        $stage='Store';
        $qrCodes_count=StageQrCodeLock::where('stage','=',$stage)->where('activity','=',$activity)->where('status','=',1)->count();
        return view('stagewise-issue.sf_create',compact('d11Datas','current_date','qrCodes_count'));
    }


    public function sfIssuePartFetchEntry(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;
        $new_d11Datas=TransDataD11::with('rcmaster')->where('rc_id','=',$rc_no)->first();
        $d11Datas  = DB::table('trans_data_d11_s')
        ->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as avl_qty'),'trans_data_d11_s.*')
        ->where('rc_id', $rc_no)
        ->first();
        $rc_datas='<option value="'.$new_d11Datas->rcmaster->id.'">'.$new_d11Datas->rcmaster->rc_id.'</option>';
        $qr_rc_id=$new_d11Datas->rcmaster->id;
        // dd($d11Datas);
        $select_rcno=$d11Datas->rc_id;
        $avl_qty=$d11Datas->avl_qty;
        $part_id=$d11Datas->part_id;
        $partData=ChildProductMaster::find($part_id);
        $part='<option value="'.$partData->id.'">'.$partData->child_part_no.'</option>';
        $current_process_id=$d11Datas->next_process_id;
        $current_product_process_id=$d11Datas->next_product_process_id;
        $process=ItemProcesmaster::find($current_process_id);
        $current_stock_id='<option value="'.$process->id.'">'.$process->operation.'</option>';
        $current_process=ProductProcessMaster::find($current_product_process_id);
        $current_process_order_id=$current_process->process_order_id;

        $fifoCheck=TransDataD11::with('rcmaster')->where('part_id', $part_id)->where('rc_status', 1)->whereIn('next_process_id',[6,7,8])->first();
        $fifoRcNo=$fifoCheck->rcmaster->rc_id;
        $fifoRcid=$fifoCheck->rc_id;

        if ($fifoRcid==$rc_no) {
            $success = true;
        } else {
            $success = false;
        }

        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('bom_masters AS b', 'a.rm_id', '=', 'b.rm_id')
        ->select('b.input_usage as bom')
        ->where('a.part_id','=',$part_id)
        ->where('a.rc_id','=',$rc_no)
        ->where('a.process_id','=',$d11Datas->process_id)
        ->where('b.status','=',1)
        ->first();

        $bom=$d12Datas->bom;

        $next_productProcess=DB::table('item_procesmasters as a')
            ->join('product_process_masters AS b', 'a.id', '=', 'b.process_master_id')
            ->join('child_product_masters as c', 'b.part_id', '=', 'c.id')
            ->select('b.process_master_id as process_id','b.process_order_id','b.id')
            ->where('a.operation_type','=','STOCKING POINT')
            ->where('b.process_order_id','>',$current_process_order_id)
            ->where('a.status','=',1)
            ->where('b.status','=',1)
            ->where('c.id','=',$part_id)
            ->first();

        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');
        if ($current_process_id==6) {
            $rc="B";
            $current_operation_id=[6,8];
        }elseif ($current_process_id==8) {
            $rc="B";
            $current_operation_id=[6,8];
        }else{
            $rc="C";
            $current_operation_id=[7];
        }
		$current_rcno=$rc.$current_year;
        $count1=RouteMaster::whereIn('process_id',$current_operation_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        // $count=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->get()->count();
        if ($count1 > 0) {
            // $rc_data=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->first();
            $rc_data=RouteMaster::whereIn('process_id',$current_operation_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $rcnumber=$rc_data['rc_id']??NULL;
            if ($current_process_id==6) {
                $old_rcnumber=str_replace("B","",$rcnumber);
            }elseif ($current_process_id==8) {
                $old_rcnumber=str_replace("B","",$rcnumber);
            }
            else {
                $old_rcnumber=str_replace("C","",$rcnumber);
            }
            $old_rcnumber_data=str_pad($old_rcnumber+1,9,0,STR_PAD_LEFT);
            if ($current_process_id==6||$current_process_id==8) {
                $new_rcnumber='B'.$old_rcnumber_data;
            }else {
                $new_rcnumber='C'.$old_rcnumber_data;
            }
        }else{
            $str='000001';
            $new_rcnumber=$current_rcno.$str;
        }

        $next_product_process_id=$next_productProcess->id;
        $next_process_id=$next_productProcess->process_id;
        $next_process_order_id=$next_productProcess->process_order_id;
        return response()->json(['process'=>$current_stock_id,'avl_qty'=>$avl_qty,'part'=>$part,'current_process_id'=>$current_process_id,'current_product_process_id'=>$current_product_process_id,'next_process_id'=>$next_process_id,'next_productprocess_id'=>$next_product_process_id,'bom'=>$bom,'rcno'=>$new_rcnumber,'success'=>$success,'fifoRcNo'=>$fifoRcNo,'rc_datas'=>$rc_datas,'qr_rc_id'=>$qr_rc_id]);

        // dd($next_process_order_id);
        // dd($next_productProcess);
        // dd($next_process);
    }

    public function sfIssueEntry(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $qrcodes_count=$request->qrcodes_count;
            if ($qrcodes_count==0) {
                $rc_card_id=$request->pre_rc_no;
            } else {
                $rc_card_id=$request->qr_rc_id;
            }
            $rcMaster=new RouteMaster;
            $rcMaster->create_date=$request->rc_date;
            $rcMaster->process_id=$request->previous_process_id;
            $rcMaster->rc_id=$request->rc_no;
            $rcMaster->prepared_by=auth()->user()->id;
            $rcMaster->save();

            $rcMasterData=RouteMaster::where('rc_id','=',$request->rc_no)->where('process_id','=',$request->previous_process_id)->first();
            $rc_id=$rcMasterData->id;

            $previousD11Datas=TransDataD11::where('rc_id','=',$rc_card_id)->where('next_process_id','=',$request->previous_process_id)->first();
            // dd($previousD11Datas);
            $old_issueqty=$previousD11Datas->issue_qty;
            $total_issue_qty=$old_issueqty+$request->issue_qty;
            $previousD11Datas->issue_qty=$total_issue_qty;
            if($request->rc_close=="yes"){
                $previousD11Datas->status=0;
                $previousD11Datas->close_date=$request->rc_date;
            }
            $previousD11Datas->updated_by = auth()->user()->id;
            $previousD11Datas->updated_at = Carbon::now();
            $previousD11Datas->update();

            $d11Datas=new TransDataD11;
            $d11Datas->open_date=$request->rc_date;
            $d11Datas->rc_id=$rc_id;
            $d11Datas->part_id=$request->part_id;
            $d11Datas->process_id=$request->previous_process_id;
            $d11Datas->product_process_id=$request->previous_product_process_id;
            $d11Datas->next_process_id=$request->next_process_id;
            $d11Datas->next_product_process_id=$request->next_product_process_id;
            $d11Datas->process_issue_qty=$request->issue_qty;
            $d11Datas->prepared_by = auth()->user()->id;
            $d11Datas->save();

            $d12Datas=new TransDataD12;
            $d12Datas->open_date=$request->rc_date;
            $d12Datas->rc_id=$rc_id;
            $d12Datas->previous_rc_id=$rc_card_id;
            $d12Datas->part_id=$request->part_id;
            $d12Datas->process_id=$request->previous_process_id;
            $d12Datas->product_process_id=$request->previous_product_process_id;
            $d12Datas->issue_qty=$request->issue_qty;
            $d12Datas->prepared_by = auth()->user()->id;
            $d12Datas->save();

            $d13Datas=new TransDataD13;
            $d13Datas->rc_id=$rc_id;
            $d13Datas->previous_rc_id=$rc_card_id;
            $d13Datas->prepared_by = auth()->user()->id;
            $d13Datas->save();
            DB::commit();

            return redirect()->route('sfissue')->withSuccess('Part Issued is Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }

    }

    public function ptsProductionReceiveEntry(Request $request){
        dd($request->all());
    }
}
