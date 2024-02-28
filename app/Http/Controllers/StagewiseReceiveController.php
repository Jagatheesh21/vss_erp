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
use Carbon\Carbon;


class StagewiseReceiveController extends Controller
{
    //Semi Finished Receive Entry  Start
    public function sfReceiveList(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->join('route_masters AS e', 'a.rc_id', '=', 'e.id')
        ->join('route_masters AS f', 'a.previous_rc_id', '=', 'f.id')
        ->select('b.operation','b.id as process_id','a.open_date','e.rc_id as rc_no','f.rc_id as previous_rc_no','a.receive_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('a.process_id', [6,7,8])
        ->whereRaw('a.rc_id=a.previous_rc_id')
        ->orderBy('a.id', 'DESC')
        ->get();
        // dd($d12Datas);
        return view('stagewise-receive.sf_view',compact('d12Datas'));
    }
    public function sfReceiveCreateForm(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas=TransDataD11::where('process_id','=',3)->where('status','=',1)->get();
        return view('stagewise-receive.sf_create',compact('d11Datas','current_date'));
    }

    public function sfPartFetchEntry(Request $request){
        // $request->all();
        // dd($request->all());
        $rc_no=$request->rc_no;
        $d11Datas=TransDataD11::where('process_id','=',3)->where('rc_id','=',$rc_no)->where('status','=',1)->first();
        // dd($d11Datas);
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
        $fifoCheck=TransDataD11::where('process_id','=',3)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->first();
        $fifoRcNo=$fifoCheck->rc_id;

        if($rc_no==$fifoRcNo){
            $success = true;
            $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
            $part='<option value="'.$part_id.'">'.$part_no.'</option>';
            $fifoRcNo=$fifoCheck->rc_no;
            $bom=$bomDatas;
            $avl_kg=$avl_qty*$bom;
            $process_id=$current_process_id;
            $product_process_id=$current_product_process_id;
            $process_check1=ProductProcessMaster::whereIn('process_master_id',[6,7,8])->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->count();
            // dd($process_check1);
            if ($process_check1==0) {
                $process=false;
                $next_process_id=0;
                $next_productprocess_id='<option value=""></option>';
            }else{
                $process=true;
                $process_checkData=DB::table('product_process_masters as a')
                ->join('item_procesmasters AS b', 'a.process_master_id', '=', 'b.id')
                ->select('b.operation','b.id as next_process_id','a.id as next_productprocess_id')
                ->whereIn('process_master_id', [6,7,8])
                ->where('part_id','=',$part_id)
                ->orderBy('a.id', 'DESC')
                ->first();
                // dd($process_checkData);
                $next_process_id=$process_checkData->next_process_id;
                $next_productprocess_id='<option value="'.$process_checkData->next_productprocess_id.'">'.$process_checkData->operation.'</option>';
            }
            $process_check=ProductProcessMaster::where('process_master_id','=',$process_id)->where('id','=',$current_product_process_id)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->count();
            if($process_check==0){
                $message=false;
            }else{
                $message=true;
            }

        }else{
            $success = false;
            $fifoRcNo=$fifoCheck->rc_id;
            $avl_qty=0;
            $avl_kg=0;
            $part='<option value=""></option>';
            $bom=0;
            $process_id=0;
            $product_process_id=0;
            $message=false;
            $process=false;
            $next_process_id=0;
            $next_productprocess_id='<option value=""></option>';
        }

        // dd($success);

        return response()->json(['success'=>$success,'fifoRcNo'=>$fifoRcNo,'avl_qty'=>$avl_qty,'part'=>$part,'bom'=>$bom,'avl_kg'=>$avl_kg,'message'=>$message,'process_id'=>$process_id,'product_process_id'=>$product_process_id,'next_process_id'=>$next_process_id,'next_productprocess_id'=>$next_productprocess_id,'process'=>$process]);

        // $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
        // dd($d11Datas->part_id);
    }

    public function sfReceiveEntry(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id)->where('product_process_id','=',$request->previous_product_process_id)->first();
            if($request->rc_close=="yes"){
                // dd($request->rc_date);
                $d11Datas->close_date=$request->rc_date;
                $d11Datas->status=0;
            }
            $d11Datas->receive_qty=$request->receive_qty;
            $d11Datas->updated_by = auth()->user()->id;
            $d11Datas->updated_at = Carbon::now();
            $d11Datas->update();
            // dd($d11Datas->receive_qty);

            $d12Datas=new TransDataD12;
            $d12Datas->open_date=$request->rc_date;
            $d12Datas->rc_id=$request->rc_no;
            $d12Datas->previous_rc_id=$request->rc_no;
            $d12Datas->part_id=$request->part_id;
            $d12Datas->process_id=$request->next_process_id;
            $d12Datas->product_process_id=$request->next_productprocess_id;
            $d12Datas->receive_qty=$request->receive_qty;
            $d12Datas->prepared_by = auth()->user()->id;
            $d12Datas->save();
            DB::commit();
            return back()->withSuccess('Part Received is Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    //Semi Finished Receive Entry  End


    // Out Store Receive Entry Start

    public function osReceiveList(){
    //     $status = 1;
    //    dd(TransDataD12::whereHas('previous_rcmaster',function(Builder $query ) use ($status){
    //     $query->where(['status'=>$status]);
    //    })->whereColumn('created_at','updated_at')
    //    ->get()) ;

        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->join('route_masters AS e', 'a.rc_id', '=', 'e.id')
        ->join('route_masters AS f', 'a.previous_rc_id', '=', 'f.id')
        ->select('b.operation','b.id as process_id','a.open_date','e.rc_id as rc_no','f.rc_id as previous_rc_no','a.receive_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('a.process_id', [16,17,21])
        ->whereRaw('a.rc_id=a.previous_rc_id')
        ->orderBy('a.id', 'DESC')
        ->get();
        // dd($d12Datas);
        return view('stagewise-receive.os_view',compact('d12Datas'));
    }

    public function osReceiveCreateForm(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas=TransDataD11::whereIn('process_id',[6,7,8,21])->where('status','=',1)->get();
        return view('stagewise-receive.os_create',compact('d11Datas','current_date'));
    }

    public function osPartFetchEntry(Request $request){
        // $request->all();
        // dd($request->all());
        $rc_no=$request->rc_no;
        $d11Datas=TransDataD11::whereIn('process_id',[6,7,8,21])->where('rc_id','=',$rc_no)->where('status','=',1)->first();
        // dd($d11Datas);
        $part_id=$d11Datas->part_id;
        $current_process_id=$d11Datas->process_id;
        $current_product_process_id=$d11Datas->product_process_id;
        $next_operation_id=$d11Datas->next_process_id;
        $next_operation_process_id=$d11Datas->next_product_process_id;
        $previous_process_issue_qty=$d11Datas->process_issue_qty;
        $receive_qty=$d11Datas->receive_qty;
        $reject_qty=$d11Datas->reject_qty;
        $rework_qty=$d11Datas->rework_qty;

        $bomDatas=BomMaster::where('child_part_id','=',$part_id)->sum('output_usage');
        if ($current_process_id==3) {
            $process_issue_qty=floor(($previous_process_issue_qty/$bomDatas));
        }else{
            $process_issue_qty=$d11Datas->process_issue_qty;
        }

        $partCheck=ChildProductMaster::find($part_id);
        $part_no=$partCheck->child_part_no;
        $fifoCheck=TransDataD11::where('process_id','=',$current_process_id)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->first();
        $fifoRcNo=$fifoCheck->rc_id;
        // dd($fifoRcNo);
        if($rc_no==$fifoRcNo){
            $success = true;
            $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
            $part='<option value="'.$part_id.'">'.$part_no.'</option>';
            $fifoRcNo=$fifoCheck->rc_no;
            $bom=$bomDatas;
            if ($current_process_id==3) {
                $avl_kg=$avl_qty*$bom;
            }else{
                $avl_kg=$avl_qty;
            }
        // dd($avl_qty);

            $process_id=$current_process_id;
            $product_process_id=$current_product_process_id;
            $process_check1=ProductProcessMaster::whereIn('process_master_id',[6,7,8,21])->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->count();
            // dd($process_check1);
            if ($process_check1==0) {
                $process=false;
                $next_process_id=0;
                $next_productprocess_id='<option value=""></option>';
            }else{
                $process=true;
                $process_checkData=DB::table('product_process_masters as a')
                ->join('item_procesmasters AS b', 'a.process_master_id', '=', 'b.id')
                ->select('b.operation','b.id as next_process_id','a.id as next_productprocess_id')
                ->where('process_master_id','=' ,$next_operation_id)
                ->where('part_id','=',$part_id)
                ->orderBy('a.id', 'DESC')
                ->first();
                // dd($process_checkData);
                $next_process_id=$process_checkData->next_process_id;
                $next_productprocess_id='<option value="'.$process_checkData->next_productprocess_id.'">'.$process_checkData->operation.'</option>';
            }
            $process_check=ProductProcessMaster::where('process_master_id','=',$process_id)->where('id','=',$current_product_process_id)->where('part_id','=',$part_id)->where('status','=',1)->orderBy('id', 'ASC')->count();
            if($process_check==0){
                $message=false;
            }else{
                $message=true;
            }

        }else{
            $success = false;
            $fifoRcNo=$fifoCheck->rc_id;
            $avl_qty=0;
            $avl_kg=0;
            $part='<option value=""></option>';
            $bom=0;
            $process_id=0;
            $product_process_id=0;
            $message=false;
            $process=false;
            $next_process_id=0;
            $next_productprocess_id='<option value=""></option>';
        }

        // dd($success);

        return response()->json(['success'=>$success,'fifoRcNo'=>$fifoRcNo,'avl_qty'=>$avl_qty,'part'=>$part,'bom'=>$bom,'avl_kg'=>$avl_kg,'message'=>$message,'process_id'=>$process_id,'product_process_id'=>$product_process_id,'next_process_id'=>$next_process_id,'next_productprocess_id'=>$next_productprocess_id,'process'=>$process]);

        // $avl_qty=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));
        // dd($d11Datas->part_id);
    }

    public function osReceiveEntry(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id)->where('product_process_id','=',$request->previous_product_process_id)->first();
            if($request->rc_close=="yes"){
                // dd($request->rc_date);
                $d11Datas->close_date=$request->rc_date;
                $d11Datas->status=0;
            }
            $d11Datas->receive_qty=$request->receive_qty;
            $d11Datas->updated_by = auth()->user()->id;
            $d11Datas->updated_at = Carbon::now();
            $d11Datas->update();
            // dd($d11Datas->receive_qty);

            $d12Datas=new TransDataD12;
            $d12Datas->open_date=$request->rc_date;
            $d12Datas->rc_id=$request->rc_no;
            $d12Datas->previous_rc_id=$request->rc_no;
            $d12Datas->part_id=$request->part_id;
            $d12Datas->process_id=$request->next_process_id;
            $d12Datas->product_process_id=$request->next_productprocess_id;
            $d12Datas->receive_qty=$request->receive_qty;
            $d12Datas->prepared_by = auth()->user()->id;
            $d12Datas->save();
            DB::commit();
            return back()->withSuccess('Part Received is Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}