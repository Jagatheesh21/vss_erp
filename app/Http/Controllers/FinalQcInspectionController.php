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
    //  DB::beginTransaction();
    //  try {
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
                            $finalQualityData->offer_qty=$balance_qty;
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


                         $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
                            $finalQualityData->offer_qty=$balance_qty;
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

                        $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
                                $finalQualityData->offer_qty=$balance_qty;
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
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
                         $finalQualityData->offer_qty=$balance_qty;
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


                      $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
                                $finalQualityData->offer_qty=$balance_qty;
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
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
                                $finalQualityData->offer_qty=$balance_qty;
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
                            $partRejectionData->prepared_by = auth()->user()->id;
                            $partRejectionData->save();

                            $d11Datas=TransDataD11::where('process_id','=',$request->previous_process_id[$key])->where('product_process_id','=',$request->previous_product_process_id[$key])->first();
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
            //  DB::commit();
            //  return back()->withSuccess('Your Inspection Data Is Submitted Successfully!');

        //  } catch (\Throwable $th) {
        //      //throw $th;
        //  dd($th->getMessage());

        //     //  DB::rollback();
        //      return back()->withErrors($th->getMessage());
        //  }
 }

    /**
     * Display the specified resource.
     */
    public function show(FinalQcInspection $finalQcInspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinalQcInspection $finalQcInspection)
    {
        //
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
