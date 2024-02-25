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
        ->select('b.operation','b.id as process_id','a.open_date','a.rc_no','a.previous_rc_no','a.issue_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('process_id', [3,4,5])
        ->whereRaw('a.rc_no!=a.previous_rc_no')
        ->orderBy('a.id', 'DESC')
        ->get();
    //    dd($d12Datas);
       return view('stagewise-issue.sf_view',compact('d12Datas'));
    }

    public function sfIssueCreateForm(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas  = DB::table('trans_data_d11_s')
            ->selectRaw('rc_no')
            ->whereIn('next_process_id', [3,4,5])
            ->havingRaw('(SUM(receive_qty)-SUM(issue_qty)) >?', [0])
            ->get();
    // dd($d11Datas);
        return view('stagewise-issue.sf_create',compact('d11Datas','current_date'));
    }


    public function sfIssuePartFetchEntry(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;

        $d11Datas  = DB::table('trans_data_d11_s')
        ->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as avl_qty'),'trans_data_d11_s.*')
        ->where('rc_no', $rc_no)
        ->first();
        // dd($d11Datas);
        $avl_qty=$d11Datas->avl_qty;
        $part_id=$d11Datas->part_id;
        $current_process_id=$d11Datas->next_process_id;
        $current_product_process_id=$d11Datas->next_product_process_id;
        $process=ItemProcesmaster::find($current_process_id);
        $current_stock_id='<option value="'.$process->id.'">'.$process->operation.'</option>';
        $current_process=ProductProcessMaster::find($current_product_process_id);
        $current_process_order_id=$current_process->process_order_id;
        $next_process_order_id=$current_process_order_id+1;
        $next_process=ProductProcessMaster::where('process_order_id','=',$next_process_order_id)->where('part_id','=',$part_id)->first();
        $next_processData=ItemProcesmaster::
        // dd($next_process_order_id);
        dd($next_process);
        dd($next_process);
    }

    public function sfIssueEntry(Request $request){
        dd($request->all());

    }
}
