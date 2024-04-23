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
use App\Models\PtsphospatingMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\BomMaster;
use App\Models\RouteMaster;
use App\Models\DcMaster;
use App\Models\ChildProductMaster;
use App\Models\FinalQcInspection;
use App\Models\PartRejectionHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\StoreFinalQcInspectionRequest;
use App\Http\Requests\UpdateFinalQcInspectionRequest;

class FinalQcInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $fqcDatas=FinalQcInspection::with(['current_rcmaster','previous_rcmaster','partmaster','currentprocessmaster','nextprocessmaster','inspector_usermaster'])->whereNotIn('process_id',[18,19,20])->orderBy('id', 'DESC')->get();
        return view('fqc_inspection.fqc_view',compact('fqcDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $fqcDatas=FinalQcInspection::with(['current_rcmaster','previous_rcmaster','partmaster','currentprocessmaster','nextprocessmaster','inspector_usermaster'])->where('status','=',0)->whereNotIn('process_id',[18,19,20])->orderBy('id', 'ASC')->get();
        return view('fqc_inspection.fqc_create',compact('fqcDatas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinalQcInspectionRequest $request)
    {
        //
        // dd($request->all());
     // dd($request->all());
     DB::beginTransaction();
     try {
             date_default_timezone_set('Asia/Kolkata');
             $current_date=date('Y-m-d');
             // dd($request->select_all);
             $fqc_ids=$request->fqc_id;
             $select_all=($request->select_all)??NULL;
             $status_all=$request->status_all;
             // dd($select_all??NULL);
             if($select_all==NULL){
                 // dd($request->status);
                 foreach ($fqc_ids as $key => $fqc_id) {
                     if ($request->status[$key]==1) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){
                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status[$key];
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->inspect_qty=$request->offer_qty[$key];
                            $finalQualityData->approve_qty=$request->inspect_qty[$key];
                            $finalQualityData->rework_qty=0;
                            $finalQualityData->reject_qty=0;
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();
                        }else{
                            $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status[$key];
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->offer_qty=$request->inspect_qty[$key];
                            $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                            $finalQualityData->approve_qty=$request->inspect_qty[$key];
                            $finalQualityData->rework_qty=0;
                            $finalQualityData->reject_qty=0;
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();

                            $newfinalQualityData=new FinalQcInspection;
                            $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                            $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                            $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                            $newfinalQualityData->part_id=$finalQualityData->part_id;
                            $newfinalQualityData->process_id=$finalQualityData->process_id;
                            $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                            $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                            $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                            $newfinalQualityData->offer_qty=$balance_qty;
                            $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                            $newfinalQualityData->status=0;
                            $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                            $newfinalQualityData->save();
                        }


                         $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                         if($request->rc_status[$key]==0){
                             // dd($request->rc_date);
                             $d11Datas->close_date=$current_date;
                             $d11Datas->status=0;
                         }
                         $total_receive_qty=(($d11Datas->receive_qty)+($request->inspect_qty[$key]));
                         $d11Datas->receive_qty=$total_receive_qty;
                         $d11Datas->updated_by = auth()->user()->id;
                         $d11Datas->updated_at = Carbon::now();
                         $d11Datas->update();
                         // dd($d11Datas->receive_qty);

                         $d12Datas=new TransDataD12;
                         $d12Datas->open_date=$current_date;
                         $d12Datas->rc_id=$request->rc_id[$key];
                         $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                         $d12Datas->part_id=$request->part_id[$key];
                         $d12Datas->process_id=$request->next_process_id[$key];
                         $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                         $d12Datas->receive_qty=$request->inspect_qty[$key];
                         $d12Datas->prepared_by = auth()->user()->id;
                         $d12Datas->save();

                     }elseif ($request->status[$key]==2) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){

                        $finalQualityData=FinalQcInspection::find($fqc_id);
                        $finalQualityData->status=$request->status[$key];
                        $finalQualityData->reason=$request->reason[$key];
                        $finalQualityData->inspect_qty=$request->offer_qty[$key];
                        $finalQualityData->approve_qty=0;
                        $finalQualityData->rework_qty=0;
                        $finalQualityData->reject_qty=$request->inspect_qty[$key];
                        $finalQualityData->inspect_by=auth()->user()->id;
                        $finalQualityData->rc_status=$request->rc_status[$key];
                        $finalQualityData->updated_by = auth()->user()->id;
                        $finalQualityData->update();
                        }else{
                            $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status[$key];
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->offer_qty=$request->inspect_qty[$key];
                            $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                            $finalQualityData->approve_qty=0;
                            $finalQualityData->rework_qty=0;
                            $finalQualityData->reject_qty=$request->inspect_qty[$key];
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();

                            // dd($finalQualityData);
                            $newfinalQualityData=new FinalQcInspection;
                            $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                            $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                            $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                            $newfinalQualityData->part_id=$finalQualityData->part_id;
                            $newfinalQualityData->process_id=$finalQualityData->process_id;
                            $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                            $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                            $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                            $newfinalQualityData->offer_qty=$balance_qty;
                            $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                            $newfinalQualityData->status=0;
                            $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                            $newfinalQualityData->save();
                        }

                        $partRejectionData=new PartRejectionHistory;
                        $partRejectionData->offer_date=$current_date;
                        $partRejectionData->type=$request->status[$key];
                        $partRejectionData->rc_id=$request->rc_id[$key];
                        $partRejectionData->previous_rc_id=$request->previous_rc_id[$key];
                        $partRejectionData->part_id=$request->part_id[$key];
                        $partRejectionData->process_id=$request->previous_process_id[$key];
                        $partRejectionData->product_process_id=$request->previous_product_process_id[$key];
                        $partRejectionData->next_process_id=$request->next_process_id[$key];
                        $partRejectionData->next_product_process_id=$request->next_productprocess_id[$key];
                        $partRejectionData->reason=$request->reason[$key];
                        $partRejectionData->inspect_qty=$request->inspect_qty[$key];
                        $partRejectionData->reject_qty=$request->inspect_qty[$key];
                        $partRejectionData->prepared_by = auth()->user()->id;
                        $partRejectionData->save();

                        $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                        // dd($d11Datas);
                        if($request->rc_status[$key]==0){
                            // dd($request->rc_date);
                            $d11Datas->close_date=$current_date;
                            $d11Datas->status=0;
                        }
                        $total_reject_qty=(($d11Datas->reject_qty)+($request->inspect_qty[$key]));
                        // dd($total_reject_qty);

                        $d11Datas->reject_qty=$total_reject_qty;
                        $d11Datas->updated_by = auth()->user()->id;
                        $d11Datas->updated_at = Carbon::now();
                        $d11Datas->update();

                        $d12Datas=new TransDataD12;
                        $d12Datas->open_date=$current_date;
                        $d12Datas->rc_id=$request->rc_id[$key];
                        $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                        $d12Datas->part_id=$request->part_id[$key];
                        $d12Datas->process_id=$request->next_process_id[$key];
                        $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                        $d12Datas->reject_qty=$request->inspect_qty[$key];
                        $d12Datas->prepared_by = auth()->user()->id;
                        $d12Datas->save();

                     }elseif ($request->status[$key]==3) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){
                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status[$key];
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->inspect_qty=$request->offer_qty[$key];
                            $finalQualityData->approve_qty=0;
                            $finalQualityData->rework_qty=$request->inspect_qty[$key];
                            $finalQualityData->reject_qty=0;
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();
                            }else{
                                $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                                $finalQualityData=FinalQcInspection::find($fqc_id);
                                $finalQualityData->status=$request->status[$key];
                                $finalQualityData->reason=$request->reason[$key];
                                $finalQualityData->offer_qty=$request->inspect_qty[$key];
                                $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                                $finalQualityData->approve_qty=0;
                                $finalQualityData->rework_qty=$request->inspect_qty[$key];
                                $finalQualityData->reject_qty=0;
                                $finalQualityData->inspect_by=auth()->user()->id;
                                $finalQualityData->rc_status=$request->rc_status[$key];
                                $finalQualityData->updated_by = auth()->user()->id;
                                $finalQualityData->update();

                                $newfinalQualityData=new FinalQcInspection;
                                $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                                $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                                $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                                $newfinalQualityData->part_id=$finalQualityData->part_id;
                                $newfinalQualityData->process_id=$finalQualityData->process_id;
                                $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                                $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                                $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                                $newfinalQualityData->offer_qty=$balance_qty;
                                $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                                $newfinalQualityData->status=0;
                                $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                                $newfinalQualityData->save();
                            }

                            $partRejectionData=new PartRejectionHistory;
                            $partRejectionData->offer_date=$current_date;
                            $partRejectionData->type=$request->status[$key];
                            $partRejectionData->rc_id=$request->rc_id[$key];
                            $partRejectionData->previous_rc_id=$request->previous_rc_id[$key];
                            $partRejectionData->part_id=$request->part_id[$key];
                            $partRejectionData->process_id=$request->previous_process_id[$key];
                            $partRejectionData->product_process_id=$request->previous_product_process_id[$key];
                            $partRejectionData->next_process_id=$request->next_process_id[$key];
                            $partRejectionData->next_product_process_id=$request->next_productprocess_id[$key];
                            $partRejectionData->reason=$request->reason[$key];
                            $partRejectionData->inspect_qty=$request->inspect_qty[$key];
                            $partRejectionData->reject_qty=$request->inspect_qty[$key];
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                            if($request->rc_status[$key]==0){
                                // dd($request->rc_date);
                                $d11Datas->close_date=$current_date;
                                $d11Datas->status=0;
                            }
                            $total_onhold_qty=(($d11Datas->rework_qty)+($request->inspect_qty[$key]));
                            $d11Datas->rework_qty=$total_onhold_qty;
                            $d11Datas->updated_by = auth()->user()->id;
                            $d11Datas->updated_at = Carbon::now();
                            $d11Datas->update();

                            $d12Datas=new TransDataD12;
                            $d12Datas->open_date=$current_date;
                            $d12Datas->rc_id=$request->rc_id[$key];
                            $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                            $d12Datas->part_id=$request->part_id[$key];
                            $d12Datas->process_id=$request->next_process_id[$key];
                            $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                            $d12Datas->rework_qty=$request->inspect_qty[$key];
                            $d12Datas->prepared_by = auth()->user()->id;
                            $d12Datas->save();
                     }
                 }
             }else{
                 foreach ($fqc_ids as $key => $fqc_id) {
                     if ($status_all==1) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){
                         $finalQualityData=FinalQcInspection::find($fqc_id);
                         $finalQualityData->status=$request->status_all;
                         $finalQualityData->reason=$request->reason[$key];
                         $finalQualityData->inspect_qty=$request->offer_qty[$key];
                         $finalQualityData->approve_qty=$request->inspect_qty[$key];
                         $finalQualityData->rework_qty=0;
                         $finalQualityData->reject_qty=0;
                         $finalQualityData->inspect_by=auth()->user()->id;
                         $finalQualityData->rc_status=$request->rc_status[$key];
                         $finalQualityData->updated_by = auth()->user()->id;
                         $finalQualityData->update();
                     }else{
                         $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                         $finalQualityData=FinalQcInspection::find($fqc_id);
                         $finalQualityData->status=$request->status_all;
                         $finalQualityData->reason=$request->reason[$key];
                         $finalQualityData->offer_qty=$request->inspect_qty[$key];
                         $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                         $finalQualityData->approve_qty=$request->inspect_qty[$key];
                         $finalQualityData->rework_qty=0;
                         $finalQualityData->reject_qty=0;
                         $finalQualityData->inspect_by=auth()->user()->id;
                         $finalQualityData->rc_status=$request->rc_status[$key];
                         $finalQualityData->updated_by = auth()->user()->id;
                         $finalQualityData->update();

                         $newfinalQualityData=new FinalQcInspection;
                         $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                         $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                         $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                         $newfinalQualityData->part_id=$finalQualityData->part_id;
                         $newfinalQualityData->process_id=$finalQualityData->process_id;
                         $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                         $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                         $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                         $newfinalQualityData->offer_qty=$balance_qty;
                         $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                         $newfinalQualityData->status=0;
                         $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                         $newfinalQualityData->save();
                     }


                      $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                      if($request->rc_status[$key]==0){
                          // dd($request->rc_date);
                          $d11Datas->close_date=$current_date;
                          $d11Datas->status=0;
                      }
                      $total_receive_qty=(($d11Datas->receive_qty)+($request->inspect_qty[$key]));
                      $d11Datas->receive_qty=$total_receive_qty;
                      $d11Datas->updated_by = auth()->user()->id;
                      $d11Datas->updated_at = Carbon::now();
                      $d11Datas->update();
                      // dd($d11Datas->receive_qty);

                      $d12Datas=new TransDataD12;
                      $d12Datas->open_date=$current_date;
                      $d12Datas->rc_id=$request->rc_id[$key];
                      $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                      $d12Datas->part_id=$request->part_id[$key];
                      $d12Datas->process_id=$request->next_process_id[$key];
                      $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                      $d12Datas->receive_qty=$request->inspect_qty[$key];
                      $d12Datas->prepared_by = auth()->user()->id;
                      $d12Datas->save();
                     }elseif ($status_all==2) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){

                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status_all;
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->inspect_qty=$request->offer_qty[$key];
                            $finalQualityData->approve_qty=0;
                            $finalQualityData->rework_qty=0;
                            $finalQualityData->reject_qty=$request->inspect_qty[$key];
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();
                            }else{
                                $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                                $finalQualityData=FinalQcInspection::find($fqc_id);
                                $finalQualityData->status=$request->status_all;
                                $finalQualityData->reason=$request->reason[$key];
                                $finalQualityData->offer_qty=$request->inspect_qty[$key];
                                $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                                $finalQualityData->approve_qty=0;
                                $finalQualityData->rework_qty=0;
                                $finalQualityData->reject_qty=$request->inspect_qty[$key];
                                $finalQualityData->inspect_by=auth()->user()->id;
                                $finalQualityData->rc_status=$request->rc_status[$key];
                                $finalQualityData->updated_by = auth()->user()->id;
                                $finalQualityData->update();

                                $newfinalQualityData=new FinalQcInspection;
                                $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                                $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                                $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                                $newfinalQualityData->part_id=$finalQualityData->part_id;
                                $newfinalQualityData->process_id=$finalQualityData->process_id;
                                $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                                $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                                $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                                $newfinalQualityData->offer_qty=$balance_qty;
                                $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                                $newfinalQualityData->status=0;
                                $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                                $newfinalQualityData->save();
                            }

                            $partRejectionData=new PartRejectionHistory;
                            $partRejectionData->offer_date=$current_date;
                            $partRejectionData->type=$request->status_all;
                            $partRejectionData->rc_id=$request->rc_id[$key];
                            $partRejectionData->previous_rc_id=$request->previous_rc_id[$key];
                            $partRejectionData->part_id=$request->part_id[$key];
                            $partRejectionData->process_id=$request->previous_process_id[$key];
                            $partRejectionData->product_process_id=$request->previous_product_process_id[$key];
                            $partRejectionData->next_process_id=$request->next_process_id[$key];
                            $partRejectionData->next_product_process_id=$request->next_productprocess_id[$key];
                            $partRejectionData->reason=$request->reason[$key];
                            $partRejectionData->inspect_qty=$request->inspect_qty[$key];
                            $partRejectionData->reject_qty=$request->inspect_qty[$key];
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                            if($request->rc_status[$key]==0){
                                // dd($request->rc_date);
                                $d11Datas->close_date=$current_date;
                                $d11Datas->status=0;
                            }
                            $total_reject_qty=(($d11Datas->reject_qty)+($request->inspect_qty[$key]));
                            $d11Datas->reject_qty=$total_reject_qty;
                            $d11Datas->updated_by = auth()->user()->id;
                            $d11Datas->updated_at = Carbon::now();
                            $d11Datas->update();

                            $d12Datas=new TransDataD12;
                            $d12Datas->open_date=$current_date;
                            $d12Datas->rc_id=$request->rc_id[$key];
                            $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                            $d12Datas->part_id=$request->part_id[$key];
                            $d12Datas->process_id=$request->next_process_id[$key];
                            $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                            $d12Datas->reject_qty=$request->inspect_qty[$key];
                            $d12Datas->prepared_by = auth()->user()->id;
                            $d12Datas->save();
                     }elseif ($status_all==3) {
                        if($request->offer_qty[$key]==$request->inspect_qty[$key]){
                            $finalQualityData=FinalQcInspection::find($fqc_id);
                            $finalQualityData->status=$request->status_all;
                            $finalQualityData->reason=$request->reason[$key];
                            $finalQualityData->inspect_qty=$request->offer_qty[$key];
                            $finalQualityData->approve_qty=0;
                            $finalQualityData->rework_qty=$request->inspect_qty[$key];
                            $finalQualityData->reject_qty=0;
                            $finalQualityData->inspect_by=auth()->user()->id;
                            $finalQualityData->rc_status=$request->rc_status[$key];
                            $finalQualityData->updated_by = auth()->user()->id;
                            $finalQualityData->update();
                            }else{
                                $balance_qty=$request->offer_qty[$key]-$request->inspect_qty[$key];
                                $finalQualityData=FinalQcInspection::find($fqc_id);
                                $finalQualityData->status=$request->status_all;
                                $finalQualityData->reason=$request->reason[$key];
                                $finalQualityData->offer_qty=$request->inspect_qty[$key];
                                $finalQualityData->inspect_qty=$request->inspect_qty[$key];
                                $finalQualityData->approve_qty=0;
                                $finalQualityData->rework_qty=$request->inspect_qty[$key];
                                $finalQualityData->reject_qty=0;
                                $finalQualityData->inspect_by=auth()->user()->id;
                                $finalQualityData->rc_status=$request->rc_status[$key];
                                $finalQualityData->updated_by = auth()->user()->id;
                                $finalQualityData->update();

                                $newfinalQualityData=new FinalQcInspection;
                                $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                                $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                                $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                                $newfinalQualityData->part_id=$finalQualityData->part_id;
                                $newfinalQualityData->process_id=$finalQualityData->process_id;
                                $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                                $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                                $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                                $newfinalQualityData->offer_qty=$balance_qty;
                                $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                                $newfinalQualityData->status=0;
                                $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                                $newfinalQualityData->save();
                            }

                            $partRejectionData=new PartRejectionHistory;
                            $partRejectionData->offer_date=$current_date;
                            $partRejectionData->type=$request->status_all;
                            $partRejectionData->rc_id=$request->rc_id[$key];
                            $partRejectionData->previous_rc_id=$request->previous_rc_id[$key];
                            $partRejectionData->part_id=$request->part_id[$key];
                            $partRejectionData->process_id=$request->previous_process_id[$key];
                            $partRejectionData->product_process_id=$request->previous_product_process_id[$key];
                            $partRejectionData->next_process_id=$request->next_process_id[$key];
                            $partRejectionData->next_product_process_id=$request->next_productprocess_id[$key];
                            $partRejectionData->reason=$request->reason[$key];
                            $partRejectionData->inspect_qty=$request->inspect_qty[$key];
                            $partRejectionData->reject_qty=$request->inspect_qty[$key];
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->where('rc_id','=',$request->rc_id[$key])->first();
                            if($request->rc_status[$key]==0){
                                // dd($request->rc_date);
                                $d11Datas->close_date=$current_date;
                                $d11Datas->status=0;
                            }
                            $total_onhold_qty=(($d11Datas->rework_qty)+($request->inspect_qty[$key]));
                            $d11Datas->rework_qty=$total_onhold_qty;
                            $d11Datas->updated_by = auth()->user()->id;
                            $d11Datas->updated_at = Carbon::now();
                            $d11Datas->update();

                            $d12Datas=new TransDataD12;
                            $d12Datas->open_date=$current_date;
                            $d12Datas->rc_id=$request->rc_id[$key];
                            $d12Datas->previous_rc_id=$request->previous_rc_id[$key];
                            $d12Datas->part_id=$request->part_id[$key];
                            $d12Datas->process_id=$request->next_process_id[$key];
                            $d12Datas->product_process_id=$request->next_productprocess_id[$key];
                            $d12Datas->rework_qty=$request->inspect_qty[$key];
                            $d12Datas->prepared_by = auth()->user()->id;
                            $d12Datas->save();
                     }
                 }
             }
             DB::commit();

             return redirect()->route('fqc_approval.index')->withSuccess('Your Inspection Data Is Submitted Successfully!');

         } catch (\Throwable $th) {
             //throw $th;
         dd($th->getMessage());

            //  DB::rollback();
             return back()->withErrors($th->getMessage());
         }
 }

    /**
     * Display the specified resource.
     */
    public function ptsFqcList()
    {
        //
        $fqcDatas=FinalQcInspection::with(['current_rcmaster','previous_rcmaster','partmaster','currentprocessmaster','nextprocessmaster','inspector_usermaster'])->whereIn('process_id',[18,19,20])->orderBy('id', 'DESC')->get();
        return view('fqc_inspection.pts_fqc_view',compact('fqcDatas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ptsFqcCreate()
    {
        //
        $fqcDatas=FinalQcInspection::with(['current_rcmaster','previous_rcmaster','partmaster','currentprocessmaster','nextprocessmaster','inspector_usermaster'])->where('status','=',0)->whereIn('process_id',[18,19,20])->orderBy('id', 'ASC')->get();
        return view('fqc_inspection.pts_fqc_create',compact('fqcDatas'));
    }

    public function ptsFqcApproval(Request $request){
        // dd($request->all());
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');

        $previous_product_process_id=$request->previous_product_process_id;
        $next_productprocess_id=$request->next_productprocess_id;
        $rc_status=$request->rc_status;
        $fqc_ids=$request->fqc_id;
        $previous_process_id=$request->previous_process_id;
        $next_process_id=$request->next_process_id;
        $part_id=$request->part_id;
        $rc_id=$request->rc_id;
        $previous_rc_id=$request->previous_rc_id;
        $offer_qty=$request->offer_qty;
        $inspect_qty=$request->inspect_qty;
        $status=$request->status;
        $reason=$request->reason??NULL;
        $status_all=$request->status_all;
        $reason_all=$request->reason_all??NULL;
        $update_all=$request->update_all;
        $select_all=($request->select_all)??NULL;


        if($select_all==NULL){
            // dd($request->status);
            foreach ($fqc_ids as $key => $fqc_id) {
                if ($request->status[$fqc_id]==1) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){
                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status[$fqc_id];
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                       $finalQualityData->approve_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->rework_qty=0;
                       $finalQualityData->reject_qty=0;
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();
                   }else{
                       $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status[$fqc_id];
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->approve_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->rework_qty=0;
                       $finalQualityData->reject_qty=0;
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();

                       $newfinalQualityData=new FinalQcInspection;
                       $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                       $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                       $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                       $newfinalQualityData->part_id=$finalQualityData->part_id;
                       $newfinalQualityData->process_id=$finalQualityData->process_id;
                       $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                       $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                       $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                       $newfinalQualityData->offer_qty=$balance_qty;
                       $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                       $newfinalQualityData->status=0;
                       $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                       $newfinalQualityData->save();
                   }


                    $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                    if($request->rc_status[$fqc_id]==0){
                        // dd($request->rc_date);
                        $d11Datas->close_date=$current_date;
                        $d11Datas->status=0;
                    }
                    $total_receive_qty=(($d11Datas->receive_qty)+($request->inspect_qty[$fqc_id]));
                    $d11Datas->receive_qty=$total_receive_qty;
                    $d11Datas->updated_by = auth()->user()->id;
                    $d11Datas->updated_at = Carbon::now();
                    $d11Datas->update();
                    // dd($d11Datas->receive_qty);

                    $d12Datas=new TransDataD12;
                    $d12Datas->open_date=$current_date;
                    $d12Datas->rc_id=$request->rc_id[$fqc_id];
                    $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                    $d12Datas->part_id=$request->part_id[$fqc_id];
                    $d12Datas->process_id=$request->next_process_id[$fqc_id];
                    $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                    $d12Datas->receive_qty=$request->inspect_qty[$fqc_id];
                    $d12Datas->prepared_by = auth()->user()->id;
                    $d12Datas->save();

                    $count=PtsphospatingMaster::where('part_id','=',$request->part_id[$fqc_id])->count();
                    if ($count==0) {
                        $d11PartIssueDatas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                        $total_issue_qty=(($d11PartIssueDatas->issue_qty)+($request->inspect_qty[$fqc_id]));
                        $d11PartIssueDatas->issue_qty=$total_issue_qty;
                        $d11PartIssueDatas->updated_by = auth()->user()->id;
                        $d11PartIssueDatas->updated_at = Carbon::now();
                        $d11PartIssueDatas->update();
                        // dd($d11Datas->receive_qty);

                        $d12PartIssueDatas=new TransDataD12;
                        $d12PartIssueDatas->open_date=$current_date;
                        $d12PartIssueDatas->rc_id=$request->rc_id[$fqc_id];
                        $d12PartIssueDatas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                        $d12PartIssueDatas->part_id=$request->part_id[$fqc_id];
                        $d12PartIssueDatas->process_id=$request->next_process_id[$fqc_id];
                        $d12PartIssueDatas->product_process_id=$request->next_productprocess_id[$fqc_id];
                        $d12PartIssueDatas->issue_qty=$request->inspect_qty[$fqc_id];
                        $d12PartIssueDatas->prepared_by = auth()->user()->id;
                        $d12PartIssueDatas->save();


                        if ($next_process_id[$fqc_id]==19) {
                            $rc="L";
                        }
                        $current_rcno=$rc.$current_year;
                        $count1=RouteMaster::where('process_id',$next_process_id[$fqc_id])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
                        if ($count1 > 0) {
                            $rc_data=RouteMaster::where('process_id',$next_process_id[$fqc_id])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
                            $rcnumber=$rc_data['rc_id']??NULL;
                            $old_rcnumber=str_replace("L","",$rcnumber);
                            $old_rcnumber_data=str_pad($old_rcnumber+1,9,0,STR_PAD_LEFT);
                            $new_rcnumber='L'.$old_rcnumber_data;
                        }else{
                            $str='000001';
                            $new_rcnumber=$current_rcno.$str;
                        }

                        $rcMaster=new RouteMaster;
                        $rcMaster->create_date=$current_date;
                        $rcMaster->process_id=$next_process_id[$fqc_id];
                        $rcMaster->rc_id=$new_rcnumber;
                        $rcMaster->prepared_by=auth()->user()->id;
                        $rcMaster->save();

                        $rcMasterData=RouteMaster::where('rc_id','=',$new_rcnumber)->where('process_id','=',$next_process_id[$fqc_id])->first();
                        $new_rc_id=$rcMasterData->id;

                        $next_process2=ProductProcessMaster::find($next_productprocess_id[$fqc_id]);
                        $next_process_order_id2=$next_process2->process_order_id;

                        $next_process3=ProductProcessMaster::where('process_order_id','>',$next_process_order_id2)->where('part_id','=',$request->part_id[$fqc_id])->where('status','=',1)->first();
                        $next_process_id3=$next_process3->process_master_id;
                        $next_productprocess_id3=$next_process3->id;

                        $d11Datas=new TransDataD11;
                        $d11Datas->open_date=$current_date;
                        $d11Datas->rc_id=$new_rc_id;
                        $d11Datas->part_id=$request->part_id[$fqc_id];
                        $d11Datas->process_id=$next_process_id[$fqc_id];
                        $d11Datas->product_process_id=$next_productprocess_id[$fqc_id];
                        $d11Datas->next_process_id=$next_process_id3;
                        $d11Datas->next_product_process_id=$next_productprocess_id3;
                        $d11Datas->process_issue_qty=$request->inspect_qty[$fqc_id];
                        $d11Datas->prepared_by = auth()->user()->id;
                        $d11Datas->save();

                        $d12Datas=new TransDataD12;
                        $d12Datas->open_date=$current_date;
                        $d12Datas->rc_id=$new_rc_id;
                        $d12Datas->previous_rc_id=$new_rc_id;
                        $d12Datas->part_id=$request->part_id[$fqc_id];
                        $d12Datas->process_id=$next_process_id[$fqc_id];
                        $d12Datas->product_process_id=$next_productprocess_id[$fqc_id];
                        $d12Datas->issue_qty=$request->inspect_qty[$fqc_id];
                        $d12Datas->prepared_by = auth()->user()->id;
                        $d12Datas->save();

                        $d13Datas=new TransDataD13;
                        $d13Datas->rc_id=$new_rc_id;
                        $d13Datas->previous_rc_id=$rc_id[$fqc_id];
                        $d13Datas->prepared_by = auth()->user()->id;
                        $d13Datas->save();

                    }


                }elseif ($request->status[$fqc_id]==2) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){

                   $finalQualityData=FinalQcInspection::find($fqc_id);
                   $finalQualityData->status=$request->status[$fqc_id];
                   $finalQualityData->reason=$request->reason[$fqc_id];
                   $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                   $finalQualityData->approve_qty=0;
                   $finalQualityData->rework_qty=0;
                   $finalQualityData->reject_qty=$request->inspect_qty[$fqc_id];
                   $finalQualityData->inspect_by=auth()->user()->id;
                   $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                   $finalQualityData->updated_by = auth()->user()->id;
                   $finalQualityData->update();
                   }else{
                       $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status[$fqc_id];
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->approve_qty=0;
                       $finalQualityData->rework_qty=0;
                       $finalQualityData->reject_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();

                       // dd($finalQualityData);
                       $newfinalQualityData=new FinalQcInspection;
                       $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                       $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                       $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                       $newfinalQualityData->part_id=$finalQualityData->part_id;
                       $newfinalQualityData->process_id=$finalQualityData->process_id;
                       $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                       $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                       $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                       $newfinalQualityData->offer_qty=$balance_qty;
                       $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                       $newfinalQualityData->status=0;
                       $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                       $newfinalQualityData->save();
                   }

                   $partRejectionData=new PartRejectionHistory;
                   $partRejectionData->offer_date=$current_date;
                   $partRejectionData->type=$request->status[$fqc_id];
                   $partRejectionData->rc_id=$request->rc_id[$fqc_id];
                   $partRejectionData->previous_rc_id=$request->previous_rc_id[$fqc_id];
                   $partRejectionData->part_id=$request->part_id[$fqc_id];
                   $partRejectionData->process_id=$request->previous_process_id[$fqc_id];
                   $partRejectionData->product_process_id=$request->previous_product_process_id[$fqc_id];
                   $partRejectionData->next_process_id=$request->next_process_id[$fqc_id];
                   $partRejectionData->next_product_process_id=$request->next_productprocess_id[$fqc_id];
                   $partRejectionData->reason=$request->reason[$fqc_id];
                   $partRejectionData->inspect_qty=$request->inspect_qty[$fqc_id];
                   $partRejectionData->reject_qty=$request->inspect_qty[$fqc_id];
                   $partRejectionData->prepared_by = auth()->user()->id;
                   $partRejectionData->save();

                   $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                   // dd($d11Datas);
                   if($request->rc_status[$fqc_id]==0){
                       // dd($request->rc_date);
                       $d11Datas->close_date=$current_date;
                       $d11Datas->status=0;
                   }
                   $total_reject_qty=(($d11Datas->reject_qty)+($request->inspect_qty[$fqc_id]));
                   // dd($total_reject_qty);

                   $d11Datas->reject_qty=$total_reject_qty;
                   $d11Datas->updated_by = auth()->user()->id;
                   $d11Datas->updated_at = Carbon::now();
                   $d11Datas->update();

                   $d12Datas=new TransDataD12;
                   $d12Datas->open_date=$current_date;
                   $d12Datas->rc_id=$request->rc_id[$fqc_id];
                   $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                   $d12Datas->part_id=$request->part_id[$fqc_id];
                   $d12Datas->process_id=$request->next_process_id[$fqc_id];
                   $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                   $d12Datas->reject_qty=$request->inspect_qty[$fqc_id];
                   $d12Datas->prepared_by = auth()->user()->id;
                   $d12Datas->save();

                }elseif ($request->status[$fqc_id]==3) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){
                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status[$fqc_id];
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                       $finalQualityData->approve_qty=0;
                       $finalQualityData->rework_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->reject_qty=0;
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();
                       }else{
                           $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                           $finalQualityData=FinalQcInspection::find($fqc_id);
                           $finalQualityData->status=$request->status[$fqc_id];
                           $finalQualityData->reason=$request->reason[$fqc_id];
                           $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->approve_qty=0;
                           $finalQualityData->rework_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->reject_qty=0;
                           $finalQualityData->inspect_by=auth()->user()->id;
                           $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                           $finalQualityData->updated_by = auth()->user()->id;
                           $finalQualityData->update();

                           $newfinalQualityData=new FinalQcInspection;
                           $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                           $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                           $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                           $newfinalQualityData->part_id=$finalQualityData->part_id;
                           $newfinalQualityData->process_id=$finalQualityData->process_id;
                           $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                           $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                           $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                           $newfinalQualityData->offer_qty=$balance_qty;
                           $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                           $newfinalQualityData->status=0;
                           $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                           $newfinalQualityData->save();
                       }

                       $partRejectionData=new PartRejectionHistory;
                       $partRejectionData->offer_date=$current_date;
                       $partRejectionData->type=$request->status[$fqc_id];
                       $partRejectionData->rc_id=$request->rc_id[$fqc_id];
                       $partRejectionData->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $partRejectionData->part_id=$request->part_id[$fqc_id];
                       $partRejectionData->process_id=$request->previous_process_id[$fqc_id];
                       $partRejectionData->product_process_id=$request->previous_product_process_id[$fqc_id];
                       $partRejectionData->next_process_id=$request->next_process_id[$fqc_id];
                       $partRejectionData->next_product_process_id=$request->next_productprocess_id[$fqc_id];
                       $partRejectionData->reason=$request->reason[$fqc_id];
                       $partRejectionData->inspect_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->reject_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->prepared_by = auth()->user()->id;
                       $partRejectionData->save();

                       $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                       if($request->rc_status[$fqc_id]==0){
                           // dd($request->rc_date);
                           $d11Datas->close_date=$current_date;
                           $d11Datas->status=0;
                       }
                       $total_onhold_qty=(($d11Datas->rework_qty)+($request->inspect_qty[$fqc_id]));
                       $d11Datas->rework_qty=$total_onhold_qty;
                       $d11Datas->updated_by = auth()->user()->id;
                       $d11Datas->updated_at = Carbon::now();
                       $d11Datas->update();

                       $d12Datas=new TransDataD12;
                       $d12Datas->open_date=$current_date;
                       $d12Datas->rc_id=$request->rc_id[$fqc_id];
                       $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $d12Datas->part_id=$request->part_id[$fqc_id];
                       $d12Datas->process_id=$request->next_process_id[$fqc_id];
                       $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                       $d12Datas->rework_qty=$request->inspect_qty[$fqc_id];
                       $d12Datas->prepared_by = auth()->user()->id;
                       $d12Datas->save();
                }
            }
        }else{
            foreach ($fqc_ids as $key => $fqc_id) {
                if ($status_all==1) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){
                    $finalQualityData=FinalQcInspection::find($fqc_id);
                    $finalQualityData->status=$request->status_all;
                    $finalQualityData->reason=$request->reason[$fqc_id];
                    $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                    $finalQualityData->approve_qty=$request->inspect_qty[$fqc_id];
                    $finalQualityData->rework_qty=0;
                    $finalQualityData->reject_qty=0;
                    $finalQualityData->inspect_by=auth()->user()->id;
                    $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                    $finalQualityData->updated_by = auth()->user()->id;
                    $finalQualityData->update();
                }elseif (($request->offer_qty[$fqc_id])<($request->inspect_qty[$fqc_id])) {
                    return redirect()->route('ptsfqclist')->withMessage('You Inspeted More than Offer Quantity.So Please Recheck It!');
                   }
                   else{
                        $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                        $finalQualityData=FinalQcInspection::find($fqc_id);
                        $finalQualityData->status=$request->status_all;
                        $finalQualityData->reason=$request->reason[$fqc_id];
                        $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                        $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                        $finalQualityData->approve_qty=$request->inspect_qty[$fqc_id];
                        $finalQualityData->rework_qty=0;
                        $finalQualityData->reject_qty=0;
                        $finalQualityData->inspect_by=auth()->user()->id;
                        $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                        $finalQualityData->updated_by = auth()->user()->id;
                        $finalQualityData->update();

                        $newfinalQualityData=new FinalQcInspection;
                        $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                        $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                        $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                        $newfinalQualityData->part_id=$finalQualityData->part_id;
                        $newfinalQualityData->process_id=$finalQualityData->process_id;
                        $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                        $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                        $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                        $newfinalQualityData->offer_qty=$balance_qty;
                        $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                        $newfinalQualityData->status=0;
                        $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                        $newfinalQualityData->save();
                    }
                    $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                    if($request->rc_status[$fqc_id]==0){
                        // dd($request->rc_date);
                        $d11Datas->close_date=$current_date;
                        $d11Datas->status=0;
                    }
                    $total_receive_qty=(($d11Datas->receive_qty)+($request->inspect_qty[$fqc_id]));
                    $d11Datas->receive_qty=$total_receive_qty;
                    $d11Datas->updated_by = auth()->user()->id;
                    $d11Datas->updated_at = Carbon::now();
                    $d11Datas->update();
                    // dd($d11Datas->receive_qty);

                    $d12Datas=new TransDataD12;
                    $d12Datas->open_date=$current_date;
                    $d12Datas->rc_id=$request->rc_id[$fqc_id];
                    $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                    $d12Datas->part_id=$request->part_id[$fqc_id];
                    $d12Datas->process_id=$request->next_process_id[$fqc_id];
                    $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                    $d12Datas->receive_qty=$request->inspect_qty[$fqc_id];
                    $d12Datas->prepared_by = auth()->user()->id;
                    $d12Datas->save();

                    $count=PtsphospatingMaster::where('part_id','=',$request->part_id[$fqc_id])->count();
                    if ($count==0) {
                        $d11PartIssueDatas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                        $total_issue_qty=(($d11PartIssueDatas->issue_qty)+($request->inspect_qty[$fqc_id]));
                        $d11PartIssueDatas->issue_qty=$total_issue_qty;
                        $d11PartIssueDatas->updated_by = auth()->user()->id;
                        $d11PartIssueDatas->updated_at = Carbon::now();
                        $d11PartIssueDatas->update();
                        // dd($d11Datas->receive_qty);

                        $d12PartIssueDatas=new TransDataD12;
                        $d12PartIssueDatas->open_date=$current_date;
                        $d12PartIssueDatas->rc_id=$request->rc_id[$fqc_id];
                        $d12PartIssueDatas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                        $d12PartIssueDatas->part_id=$request->part_id[$fqc_id];
                        $d12PartIssueDatas->process_id=$request->next_process_id[$fqc_id];
                        $d12PartIssueDatas->product_process_id=$request->next_productprocess_id[$fqc_id];
                        $d12PartIssueDatas->issue_qty=$request->inspect_qty[$fqc_id];
                        $d12PartIssueDatas->prepared_by = auth()->user()->id;
                        $d12PartIssueDatas->save();


                        if ($next_process_id[$fqc_id]==19) {
                            $rc="L";
                        }
                        $current_rcno=$rc.$current_year;
                        $count1=RouteMaster::where('process_id',$next_process_id[$fqc_id])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
                        if ($count1 > 0) {
                            $rc_data=RouteMaster::where('process_id',$next_process_id[$fqc_id])->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
                            $rcnumber=$rc_data['rc_id']??NULL;
                            $old_rcnumber=str_replace("L","",$rcnumber);
                            $old_rcnumber_data=str_pad($old_rcnumber+1,9,0,STR_PAD_LEFT);
                            $new_rcnumber='L'.$old_rcnumber_data;
                        }else{
                            $str='000001';
                            $new_rcnumber=$current_rcno.$str;
                        }

                        $rcMaster=new RouteMaster;
                        $rcMaster->create_date=$current_date;
                        $rcMaster->process_id=$next_process_id[$fqc_id];
                        $rcMaster->rc_id=$new_rcnumber;
                        $rcMaster->prepared_by=auth()->user()->id;
                        $rcMaster->save();

                        $rcMasterData=RouteMaster::where('rc_id','=',$new_rcnumber)->where('process_id','=',$next_process_id[$fqc_id])->first();
                        $new_rc_id=$rcMasterData->id;

                        $next_process2=ProductProcessMaster::find($next_productprocess_id[$fqc_id]);
                        $next_process_order_id2=$next_process2->process_order_id;

                        $next_process3=ProductProcessMaster::where('process_order_id','>',$next_process_order_id2)->where('part_id','=',$request->part_id[$fqc_id])->where('status','=',1)->first();
                        $next_process_id3=$next_process3->process_master_id;
                        $next_productprocess_id3=$next_process3->id;

                        $d11Datas=new TransDataD11;
                        $d11Datas->open_date=$current_date;
                        $d11Datas->rc_id=$new_rc_id;
                        $d11Datas->part_id=$request->part_id[$fqc_id];
                        $d11Datas->process_id=$next_process_id[$fqc_id];
                        $d11Datas->product_process_id=$next_productprocess_id[$fqc_id];
                        $d11Datas->next_process_id=$next_process_id3;
                        $d11Datas->next_product_process_id=$next_productprocess_id3;
                        $d11Datas->process_issue_qty=$request->inspect_qty[$fqc_id];
                        $d11Datas->prepared_by = auth()->user()->id;
                        $d11Datas->save();

                        $d12Datas=new TransDataD12;
                        $d12Datas->open_date=$current_date;
                        $d12Datas->rc_id=$new_rc_id;
                        $d12Datas->previous_rc_id=$new_rc_id;
                        $d12Datas->part_id=$request->part_id[$fqc_id];
                        $d12Datas->process_id=$next_process_id[$fqc_id];
                        $d12Datas->product_process_id=$next_productprocess_id[$fqc_id];
                        $d12Datas->issue_qty=$request->inspect_qty[$fqc_id];
                        $d12Datas->prepared_by = auth()->user()->id;
                        $d12Datas->save();

                        $d13Datas=new TransDataD13;
                        $d13Datas->rc_id=$new_rc_id;
                        $d13Datas->previous_rc_id=$rc_id[$fqc_id];
                        $d13Datas->prepared_by = auth()->user()->id;
                        $d13Datas->save();

                    }
                }elseif ($status_all==2) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){

                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status_all;
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                       $finalQualityData->approve_qty=0;
                       $finalQualityData->rework_qty=0;
                       $finalQualityData->reject_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();
                    }elseif (($request->offer_qty[$fqc_id])<($request->inspect_qty[$fqc_id])) {
                        return redirect()->route('ptsfqclist')->withMessage('You Inspeted More than Offer Quantity.So Please Recheck It!');
                       }
                       else{
                           $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                           $finalQualityData=FinalQcInspection::find($fqc_id);
                           $finalQualityData->status=$request->status_all;
                           $finalQualityData->reason=$request->reason[$fqc_id];
                           $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->approve_qty=0;
                           $finalQualityData->rework_qty=0;
                           $finalQualityData->reject_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->inspect_by=auth()->user()->id;
                           $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                           $finalQualityData->updated_by = auth()->user()->id;
                           $finalQualityData->update();

                           $newfinalQualityData=new FinalQcInspection;
                           $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                           $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                           $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                           $newfinalQualityData->part_id=$finalQualityData->part_id;
                           $newfinalQualityData->process_id=$finalQualityData->process_id;
                           $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                           $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                           $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                           $newfinalQualityData->offer_qty=$balance_qty;
                           $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                           $newfinalQualityData->status=0;
                           $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                           $newfinalQualityData->save();
                       }

                       $partRejectionData=new PartRejectionHistory;
                       $partRejectionData->offer_date=$current_date;
                       $partRejectionData->type=$request->status_all;
                       $partRejectionData->rc_id=$request->rc_id[$fqc_id];
                       $partRejectionData->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $partRejectionData->part_id=$request->part_id[$fqc_id];
                       $partRejectionData->process_id=$request->previous_process_id[$fqc_id];
                       $partRejectionData->product_process_id=$request->previous_product_process_id[$fqc_id];
                       $partRejectionData->next_process_id=$request->next_process_id[$fqc_id];
                       $partRejectionData->next_product_process_id=$request->next_productprocess_id[$fqc_id];
                       $partRejectionData->reason=$request->reason[$fqc_id];
                       $partRejectionData->inspect_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->reject_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->prepared_by = auth()->user()->id;
                       $partRejectionData->save();

                       $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                       if($request->rc_status[$fqc_id]==0){
                           // dd($request->rc_date);
                           $d11Datas->close_date=$current_date;
                           $d11Datas->status=0;
                       }
                       $total_reject_qty=(($d11Datas->reject_qty)+($request->inspect_qty[$fqc_id]));
                       $d11Datas->reject_qty=$total_reject_qty;
                       $d11Datas->updated_by = auth()->user()->id;
                       $d11Datas->updated_at = Carbon::now();
                       $d11Datas->update();

                       $d12Datas=new TransDataD12;
                       $d12Datas->open_date=$current_date;
                       $d12Datas->rc_id=$request->rc_id[$fqc_id];
                       $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $d12Datas->part_id=$request->part_id[$fqc_id];
                       $d12Datas->process_id=$request->next_process_id[$fqc_id];
                       $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                       $d12Datas->reject_qty=$request->inspect_qty[$fqc_id];
                       $d12Datas->prepared_by = auth()->user()->id;
                       $d12Datas->save();
                }elseif ($status_all==3) {
                   if($request->offer_qty[$fqc_id]==$request->inspect_qty[$fqc_id]){
                       $finalQualityData=FinalQcInspection::find($fqc_id);
                       $finalQualityData->status=$request->status_all;
                       $finalQualityData->reason=$request->reason[$fqc_id];
                       $finalQualityData->inspect_qty=$request->offer_qty[$fqc_id];
                       $finalQualityData->approve_qty=0;
                       $finalQualityData->rework_qty=$request->inspect_qty[$fqc_id];
                       $finalQualityData->reject_qty=0;
                       $finalQualityData->inspect_by=auth()->user()->id;
                       $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                       $finalQualityData->updated_by = auth()->user()->id;
                       $finalQualityData->update();
                       }elseif (($request->offer_qty[$fqc_id])<($request->inspect_qty[$fqc_id])) {
                        return redirect()->route('ptsfqclist')->withMessage('You Inspeted More than Offer Quantity.So Please Recheck It!');
                       }
                       else{
                           $balance_qty=$request->offer_qty[$fqc_id]-$request->inspect_qty[$fqc_id];
                           $finalQualityData=FinalQcInspection::find($fqc_id);
                           $finalQualityData->status=$request->status_all;
                           $finalQualityData->reason=$request->reason[$fqc_id];
                           $finalQualityData->offer_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->inspect_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->approve_qty=0;
                           $finalQualityData->rework_qty=$request->inspect_qty[$fqc_id];
                           $finalQualityData->reject_qty=0;
                           $finalQualityData->inspect_by=auth()->user()->id;
                           $finalQualityData->rc_status=$request->rc_status[$fqc_id];
                           $finalQualityData->updated_by = auth()->user()->id;
                           $finalQualityData->update();

                           $newfinalQualityData=new FinalQcInspection;
                           $newfinalQualityData->offer_date=$finalQualityData->offer_date;
                           $newfinalQualityData->rc_id=$finalQualityData->rc_id;
                           $newfinalQualityData->previous_rc_id=$finalQualityData->previous_rc_id;
                           $newfinalQualityData->part_id=$finalQualityData->part_id;
                           $newfinalQualityData->process_id=$finalQualityData->process_id;
                           $newfinalQualityData->product_process_id=$finalQualityData->product_process_id;
                           $newfinalQualityData->next_process_id=$finalQualityData->next_process_id;
                           $newfinalQualityData->next_product_process_id=$finalQualityData->next_product_process_id;
                           $newfinalQualityData->offer_qty=$balance_qty;
                           $newfinalQualityData->rc_status=$finalQualityData->rc_status;
                           $newfinalQualityData->status=0;
                           $newfinalQualityData->prepared_by=$finalQualityData->prepared_by;
                           $newfinalQualityData->save();
                       }

                       $partRejectionData=new PartRejectionHistory;
                       $partRejectionData->offer_date=$current_date;
                       $partRejectionData->type=$request->status_all;
                       $partRejectionData->rc_id=$request->rc_id[$fqc_id];
                       $partRejectionData->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $partRejectionData->part_id=$request->part_id[$fqc_id];
                       $partRejectionData->process_id=$request->previous_process_id[$fqc_id];
                       $partRejectionData->product_process_id=$request->previous_product_process_id[$fqc_id];
                       $partRejectionData->next_process_id=$request->next_process_id[$fqc_id];
                       $partRejectionData->next_product_process_id=$request->next_productprocess_id[$fqc_id];
                       $partRejectionData->reason=$request->reason[$fqc_id];
                       $partRejectionData->inspect_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->reject_qty=$request->inspect_qty[$fqc_id];
                       $partRejectionData->prepared_by = auth()->user()->id;
                       $partRejectionData->save();

                       $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$fqc_id])->where('product_process_id','=',$request->previous_product_process_id[$fqc_id])->first();
                       if($request->rc_status[$fqc_id]==0){
                           // dd($request->rc_date);
                           $d11Datas->close_date=$current_date;
                           $d11Datas->status=0;
                       }
                       $total_onhold_qty=(($d11Datas->rework_qty)+($request->inspect_qty[$fqc_id]));
                       $d11Datas->rework_qty=$total_onhold_qty;
                       $d11Datas->updated_by = auth()->user()->id;
                       $d11Datas->updated_at = Carbon::now();
                       $d11Datas->update();

                       $d12Datas=new TransDataD12;
                       $d12Datas->open_date=$current_date;
                       $d12Datas->rc_id=$request->rc_id[$fqc_id];
                       $d12Datas->previous_rc_id=$request->previous_rc_id[$fqc_id];
                       $d12Datas->part_id=$request->part_id[$fqc_id];
                       $d12Datas->process_id=$request->next_process_id[$fqc_id];
                       $d12Datas->product_process_id=$request->next_productprocess_id[$fqc_id];
                       $d12Datas->rework_qty=$request->inspect_qty[$fqc_id];
                       $d12Datas->prepared_by = auth()->user()->id;
                       $d12Datas->save();
                }
            }
        }
        return redirect()->route('ptsfqclist')->withSuccess('Your Inspection Data Is Submitted Successfully!');

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinalQcInspectionRequest $request, FinalQcInspection $finalQcInspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinalQcInspection $finalQcInspection)
    {
        //
    }
}
