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
use App\Models\BomMaster;
use App\Models\ItemProcesmaster;
use App\Models\ChildProductMaster;
use App\Models\RouteMaster;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StagewiseIssueController extends Controller
{
    //Semi Finished Issue Entry Start
    public function sfIssueList(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->select('b.operation','b.id as process_id','a.open_date','a.rc_id','a.previous_rc_id','a.issue_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('process_id', [6,7,8])
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
            ->select('e.rc_id as rc_no','e.id')
            ->whereIn('a.next_process_id', [6,7,8])
            ->havingRaw('(SUM(a.receive_qty)-SUM(a.issue_qty)) >?', [0])
            ->get();
    // dd($d11Datas);
        return view('stagewise-issue.sf_create',compact('d11Datas','current_date'));
    }


    public function sfIssuePartFetchEntry(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;

        $d11Datas  = DB::table('trans_data_d11_s')
        ->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as avl_qty'),'trans_data_d11_s.*')
        ->where('rc_id', $rc_no)
        ->first();
        // dd($d11Datas);
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
        if ($current_process_id==6||$current_process_id==8) {
            $rc="B";
        }else{
            $rc="C";
        }
		$current_rcno=$rc.$current_year;
        $count1=RouteMaster::where('process_id','=',$current_process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        // $count=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->get()->count();
        if ($count1 > 0) {
            // $rc_data=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->first();
            $rc_data=RouteMaster::where('process_id','=',$current_process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $rcnumber=$rc_data['rc_id']??NULL;
            if ($current_process_id==6||$current_process_id==8) {
                $old_rcnumber=str_replace("B","",$rcnumber);
            }else {
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
        return response()->json(['process'=>$current_stock_id,'avl_qty'=>$avl_qty,'part'=>$part,'current_process_id'=>$current_process_id,'current_product_process_id'=>$current_product_process_id,'next_process_id'=>$next_process_id,'next_productprocess_id'=>$next_product_process_id,'bom'=>$bom,'rcno'=>$new_rcnumber]);

        // dd($next_process_order_id);
        // dd($next_productProcess);
        // dd($next_process);
    }

    public function sfIssueEntry(Request $request){
        dd($request->all());

    }
}
