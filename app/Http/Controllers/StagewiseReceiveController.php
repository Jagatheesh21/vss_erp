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
use App\Models\ChildProductMaster;
use Illuminate\Support\Facades\DB;

class StagewiseReceiveController extends Controller
{
    //
    public function sfReceiveList(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->select('b.operation','b.id as process_id','a.open_date','a.rc_no','a.previous_rc_no','a.receive_qty','c.child_part_no as part_no','a.prepared_by','a.created_at')
        ->whereIn('process_id', [3,4,5])
        ->orderBy('a.id', 'DESC')
        ->get();
        // dd($d12Datas);
        return view('stagewise-receive.sf_view',compact('d12Datas'));
    }
    public function sfReceiveCreateForm(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas=TransDataD11::where('process_id','=',1)->where('status','=',1)->get();
        return view('stagewise-receive.sf_create',compact('d11Datas','current_date'));
    }

    public function sfPartFetchEntry(Request $request){
        // $request->all();
        // dd($request->all());
        $rc_no=$request->rc_no;
        $d11Datas=TransDataD11::where('process_id','=',1)->where('rc_no','=',$rc_no)->where('status','=',1)->first();
        $part_id=$d11Datas->part_id;
        $current_process_id=$d11Datas->process_id;
        $current_product_process_id=$d11Datas->product_process_id;
        $previous_process_issue_qty=$d11Datas->process_issue_qty;
        $receive_qty=$d11Datas->receive_qty;
        $reject_qty=$d11Datas->reject_qty;
        $rework_qty=$d11Datas->rework_qty;

        $bomDatas=BomMaster::where('child_part_id','=',$part_id)->sum('input_usage');
        $process_issue_qty=floor(($previous_process_issue_qty/$bomDatas));

        $partCheck=ChildProductMaster::find($part_id);
        $part_no=$partCheck->child_part_no;
        $fifoCheck=TransDataD11::where('process_id','=',1)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->first();
        $fifoRcNo=$fifoCheck->rc_no;

        if($rc_no==$fifoRcNo){
            $success = true;
            $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
            $part='<option value="'.$part_id.'">'.$part_no.'</option>';
            $fifoRcNo=$fifoCheck->rc_no;
            $bom=$bomDatas;
            $avl_kg=$avl_qty*$bom;
            $process_id=$current_process_id;
            $product_process_id=$current_product_process_id;

            $process_check=ProductProcessMaster::where('process_master_id','=',$process_id)->where('id','=',$current_product_process_id)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->count();
            if($process_check==0){
                $message=false;
            }else{
                $message=true;
            }

        }else{
            $success = false;
            $fifoRcNo=$fifoCheck->rc_no;
            $avl_qty=0;
            $avl_kg=0;
            $part='<option value=""></option>';
            $bom=0;
            $process_id=0;
            $product_process_id=0;
            $message=false;

        }

        // dd($success);

        return response()->json(['success'=>$success,'fifoRcNo'=>$fifoRcNo,'avl_qty'=>$avl_qty,'part'=>$part,'bom'=>$bom,'avl_kg'=>$avl_kg,'message'=>$message,'process_id'=>$process_id,'product_process_id'=>$product_process_id]);

        // $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
        // dd($d11Datas->part_id);
    }

    public function sfReceiveEntry(Request $request){
        dd($request->all());
    }
}
