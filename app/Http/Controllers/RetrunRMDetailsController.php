<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\RawMaterial;
use App\Models\Rackmaster;
use App\Models\ModeOfUnit;
use App\Models\StageQrCodeLock;
use App\Models\GRNInwardRegister;
use App\Models\GrnQuality;
use App\Models\PODetail;
use App\Models\POProductDetail;
use App\Models\ProductProcessMaster;
use App\Models\HeatNumber;
use App\Models\BomMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\ItemProcesmaster;
use App\Models\RouteMaster;
use App\Models\RetrunRMDetails;
use App\Http\Requests\StoreRetrunRMDetailsRequest;
use App\Http\Requests\UpdateRetrunRMDetailsRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class RetrunRMDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $returnrmDatas=RetrunRMDetails::all();
        // dd($returnrmDatas);
        return view('rm_issuance.return_rm',compact('returnrmDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $d11Datas=TransDataD11::with('rcmaster')->where('rc_status','=',1)->where('process_id','=',3)->get();
        // dd($d11Datas);
        $activity='Return RM Receipt';
        $stage='Store';
        $qrCodes_count=StageQrCodeLock::where('stage','=',$stage)->where('activity','=',$activity)->where('status','=',1)->count();
        return view('rm_issuance.return_rm_create',compact('d11Datas','qrCodes_count','current_date'));
    }

    public function rmReturnPartFetchEntry(Request $request){
        // dd($request->all());
        $rc_no=$request->rc_no;
        $TransDataD11Datas=TransDataD11::with('rcmaster')->where('rc_id','=',$rc_no)->where('rc_id','=',$rc_no)->where('rc_status','!=',0)->first();
        $count=TransDataD11::with('rcmaster')->where('rc_id','=',$rc_no)->where('rc_id','=',$rc_no)->where('rc_status','!=',0)->get()->count();
        if ($count > 0) {
            $part_id=$TransDataD11Datas->part_id;
            $current_process_id=$TransDataD11Datas->process_id;
            $current_product_process_id=$TransDataD11Datas->product_process_id;

            $bomDatas=BomMaster::where('child_part_id','=',$part_id)->where('status','=',1)->sum('input_usage');
            $process_issue_qty=$TransDataD11Datas->process_issue_qty;
            $receive_qty=round(($TransDataD11Datas->receive_qty*$bomDatas),2);
            $reject_qty=round(($TransDataD11Datas->reject_qty*$bomDatas),2);
            $rework_qty=round(($TransDataD11Datas->rework_qty*$bomDatas),2);
            $avl_kg=(($process_issue_qty)-($receive_qty)-($reject_qty)-($rework_qty));

            $operation_datas=ItemProcesmaster::find($current_process_id);
            $operation='<option value="'.$operation_datas->id.'">'.$operation_datas->operation.'</option>';

            $TransDataD12Datas=TransDataD12::with(['grndata','heat_nomaster','partmaster'])->where('rc_id','=',$rc_no)->where('process_id','=',3)->first();
            // dd($TransDataD12Datas);
            $part_no='<option value="'.$TransDataD12Datas->partmaster->id.'">'.$TransDataD12Datas->partmaster->child_part_no.'</option>';
            $grn_datas='<option value="'.$TransDataD12Datas->grndata->rcmaster->id.'">'.$TransDataD12Datas->grndata->rcmaster->rc_id.'</option>';
            $rm='<option value="'.$TransDataD12Datas->grndata->poproduct->supplier_products->material->id.'">'.$TransDataD12Datas->grndata->poproduct->supplier_products->material->name.'</option>';
            $heat_no_datas='<option value="'.$TransDataD12Datas->heat_nomaster->id.'">'.$TransDataD12Datas->heat_nomaster->heatnumber.'</option>';
            $coil_no=$TransDataD12Datas->heat_nomaster->coil_no;
                $success = true;
                $lot_no=$TransDataD12Datas->heat_nomaster->lot_no;
            $tc_no=$TransDataD12Datas->heat_nomaster->tc_no;
            $rack_id='<option value="'.$TransDataD12Datas->heat_nomaster->rackmaster->id.'">'.$TransDataD12Datas->heat_nomaster->rackmaster->rack_name.'</option>';

            return response()->json(['rm'=>$rm,'success'=>$success,'avl_kg'=>$avl_kg,'part_no'=>$part_no,'operation'=>$operation,'grn_datas'=>$grn_datas,'heat_no_datas'=>$heat_no_datas,'coil_no'=>$coil_no,'lot_no'=>$lot_no,'tc_no'=>$tc_no,'rack_id'=>$rack_id]);
        } else {
            $success = false;
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRetrunRMDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RetrunRMDetails $retrunrmdetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetrunRMDetails $retrunrmdetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRetrunRMDetailsRequest $request, RetrunRMDetails $retrunrmdetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RetrunRMDetails $retrunrmdetails)
    {
        //
    }
}
