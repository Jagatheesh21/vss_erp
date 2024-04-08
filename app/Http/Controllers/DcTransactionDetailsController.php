<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Http\Requests\StoreDcTransactionDetailsRequest;
use App\Http\Requests\UpdateDcTransactionDetailsRequest;
use DB;
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
            return view('dc.create',compact('dcmasterDatas','new_rcnumber'));
    }

    public function dcPartData(Request $request){
        // dd($request->supplier_id);
        $supplier_id=$request->supplier_id;
        // dd($supplier_id);
        $count=DcMaster::with('childpart')->where('status','=',1)->where('supplier_id','=',$supplier_id)->get()->count();
        // dd($count);
        if ($count > 0) {
            $dcmasterDatas=DcMaster::with('childpart')->where('status','=',1)->where('supplier_id','=',$supplier_id)->get();
            $part_id='<option value="" selected>Select The Part Number</option>';
            foreach ($dcmasterDatas as $key => $dcmasterData) {
                $part_id.='<option value="'.$dcmasterData->childpart->id.'">'.$dcmasterData->childpart->child_part_no.'</option>';
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
        $dcmasterOperationDatas=DcMaster::with('childpart','procesmaster','supplier')->where('status','=',1)->where('supplier_id','=',$supplier_id)->where('part_id','=',$part_id)->first();
        $operation_id=$dcmasterOperationDatas->operation_id;
        $dcmasterDatas=TransDataD11::with('rcmaster')->where('next_process_id','=',$operation_id)->where('part_id','=',$part_id)->select('rc_id',DB::raw('((receive_qty)-(issue_qty)) as avl_qty'))
        ->havingRaw('avl_qty >?', [0])->get();
        $count1=TransDataD11::where('next_process_id','=',$operation_id)->where('part_id','=',$part_id)->select(DB::raw('(SUM(receive_qty)-SUM(issue_qty)) as t_avl_qty'))
        ->havingRaw('t_avl_qty >?', [0])->first();
        $t_avl_qty=$count1->t_avl_qty;
        foreach ($dcmasterDatas as $key => $dcmasterData) {
            $table='<tr>';
            $table.='<td><select name="route_card_id[]" class="form-control" id="route_card_id"><option value="'.$dcmasterData->rcmaster->id.'">'.$dcmasterData->rcmaster->rc_id.'</option></select></td>';
            $table.='<td><select name="available_quantity[]"  class="form-control"  id="available_quantity"><option value="'.$dcmasterData->avl_qty.'">'.$dcmasterData->avl_qty.'</option></select></td>';
            $table.='<td><input type="number" name="issue_quantity[]"  class="form-control"  id="issue_quantity" min="0" max="'.$dcmasterData->avl_qty.'"></td>';
            $table.='</tr>';
        }
        return response()->json(['t_avl_qty'=>$t_avl_qty,'table'=>$table]);

        // dd($count1);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcTransactionDetailsRequest $request)
    {
        //
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
