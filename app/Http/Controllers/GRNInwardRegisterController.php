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
use App\Models\ItemProcesmaster;
use App\Models\RouteMaster;
use App\Http\Requests\StoreGRNInwardRegisterRequest;
use App\Http\Requests\UpdateGRNInwardRegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class GRNInwardRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//         //SELECT
//     a.grnnumber,
//     a.grndate,
//     b.ponumber,
//     d.name AS sc_name,
//     d.supplier_code AS sc_code,
//     f.name AS rm_category,
//     g.name AS rm_desc,
//     a.inward_qty
// FROM
//     g_r_n_inward_registers AS a
// INNER JOIN p_o_details AS b
// ON
//     a.po_id = b.id
// INNER JOIN p_o_product_details AS c
// ON
//     a.p_o_product_id = c.id
// INNER JOIN suppliers AS d
// ON
//     c.supplier_id = d.id
// INNER JOIN supplier_products AS e
// ON
//     c.supplier_product_id = e.id
// INNER JOIN raw_material_categories AS f
// ON
//     e.raw_material_category_id = f.id
// INNER JOIN raw_materials AS g
// ON
//     e.raw_material_id = g.id

        $inward_datas = DB::table('g_r_n_inward_registers as a')
            ->join('p_o_details AS b', 'a.po_id', '=', 'b.id')
            ->join('route_masters AS r', 'b.ponumber', '=', 'r.id')
            ->join('route_masters AS h', 'a.grnnumber', '=', 'h.id')
            ->join('p_o_product_details AS c', 'a.p_o_product_id', '=', 'c.id')
            ->join('suppliers AS d', 'c.supplier_id', '=', 'd.id')
            ->join('supplier_products AS e', 'c.supplier_product_id', '=', 'e.id')
            ->join('raw_material_categories AS f', 'e.raw_material_category_id', '=', 'f.id')
            ->join('raw_materials AS g', 'e.raw_material_id', '=', 'g.id')
            ->select('a.id as id','h.rc_id as grnnumber','r.rc_id as ponumber', 'a.grndate','d.name AS sc_name','d.supplier_code AS sc_code','f.name AS rm_category','g.name AS rm_desc','a.inward_qty','a.approved_qty', 'a.onhold_qty', 'a.rejected_qty', 'a.issued_qty', 'a.return_qty', 'a.return_dc_qty', 'a.avl_qty', 'a.grn_close_date', 'a.approved_status', 'a.status')
            ->get();
        // dd($inward_datas);

        // $inward_datas=GRNInwardRegister::with(['podata','poproduct','rackmaster'])->get();
        return view('grn_inward.index',compact('inward_datas'));
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
		$rc="G";
		$current_rcno=$rc.$current_year;
        $process=ItemProcesmaster::where('operation','=','RM Inward')->where('status','=',1)->first();
        $process_id=$process->id;
        $count1=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        // $count=GRNInwardRegister::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->get()->count();
        if ($count1 > 0) {
            // $po_data=GRNInwardRegister::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->first();
            $po_data=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->first();
            $grnnumber=$po_data['rc_id']??NULL;
            $old_grnnumber=str_replace("G","",$grnnumber);
            $old_grnnumber_data=str_pad($old_grnnumber+1,9,0,STR_PAD_LEFT);
            $new_grnnumber='G'.$old_grnnumber_data;
        }else{
            $str='000001';
            $new_grnnumber=$current_rcno.$str;
        }
        $po_datas=PODetail::where('status','=',0)->get();
        // dd($po_datas);
        return view('grn_inward.create',compact('po_datas','new_grnnumber','current_date'));
    }

    public function grn_rmfetchdata(Request $request){
        $id=$request->id;
        $count = POProductDetail::where('id',$id)->get()->count();
        if ($count>0) {
            $po_product_datas = POProductDetail::find($id);
                $sc_product_id=$po_product_datas->supplier_product_id;
                $po_product_qty=$po_product_datas->qty;
                $rm_datas=RawMaterial::find($sc_product_id);
                $max_qty=$rm_datas->maximum_stock;
                $racks=Rackmaster::where('raw_material_id',$sc_product_id)->get();
                $sc_datas=SupplierProduct::find($sc_product_id);
                $uom_data_id=$sc_datas->uom_id;
                $uom_data=ModeOfUnit::find($uom_data_id);
                $html='';
            foreach ($racks as $key => $rack) {
                $html .= '<option value="'.$rack->id.'">'.$rack->rack_name.'</option>';
            }
            $uom='';
            $uom .= '<option value="'.$uom_data->id.'">'.$uom_data->name.'</option>';
            return response()->json(['max_qty'=>$max_qty,'html'=>$html,'count'=>$count,'uom'=>$uom,'po_qty'=>$po_product_qty]);
        }
    }

    public function addGRNItem(Request $request)
    {
        if($request->rm_id)
        {
            $id=$request->rm_id;
            $count = POProductDetail::where('id',$id)->get()->count();
            if ($count>0) {
                $po_product_datas = POProductDetail::find($id);
                $sc_product_id=$po_product_datas->supplier_product_id;
                $rm_datas=RawMaterial::find($sc_product_id);
                $racks=Rackmaster::where('raw_material_id',$sc_product_id)->get();
                $sc_datas=SupplierProduct::find($sc_product_id);
                $uom_data_id=$sc_datas->uom_id;
                $uom_data=ModeOfUnit::find($uom_data_id);
                $html = view('grn_inward.add_items',compact('uom_data','racks'))->render();
                return response()->json(['category'=>$html]);
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGRNInwardRegisterRequest $request)
    {
        //SELECT `id`, `grnnumber_id`, `rack_id`, `heat_no_id`, `inspected_by`, `inspected_date`, `inspected_qty`, `approved_qty`, `onhold_qty`, `rejected_qty`, `status`, `prepared_by`, `updated_by`, `created_at`, `updated_at` FROM `grn_qualities` WHERE 1

        // dd($request);

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'grand_total' => 'required|max:'.$request->grand_total
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->messages()->all()[0]);
                // return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            }else{
                $process=ItemProcesmaster::where('operation','=','RM Inward')->where('status','=',1)->first();
                $process_id=$process->id;

                $poDatas=PODetail::find($request->po_id);
                $pre_rc_id=$poDatas->ponumber;

                $rcMaster=new RouteMaster;
                $rcMaster->create_date=$request->grndate;
                $rcMaster->process_id=$process_id;
                $rcMaster->rc_id=$request->grnnumber;
                $rcMaster->prepared_by=auth()->user()->id;
                $rcMaster->save();

                $rcMasterData=RouteMaster::where('rc_id','=',$request->grnnumber)->where('process_id','=',$process_id)->first();
                $rc_id=$rcMasterData->id;

                $d13Datas=new TransDataD13;
                $d13Datas->rc_id=$rc_id;
                $d13Datas->previous_rc_id=$pre_rc_id;
                $d13Datas->prepared_by = auth()->user()->id;
                $d13Datas->save();

                $grn_datas = new GRNInwardRegister;
                $grn_datas->grnnumber = $rc_id;
                $grn_datas->grndate = $request->grndate;
                $grn_datas->po_id = $request->po_id;
                $grn_datas->p_o_product_id = $request->rm_id;
                $grn_datas->invoice_number = $request->invoice_number;
                $grn_datas->invoice_date = $request->invoice_date;
                $grn_datas->dc_number = $request->dc_number;
                $grn_datas->dc_date = $request->dc_date;
                $grn_datas->inward_qty = $request->grand_total;
                $grn_datas->prepared_by = auth()->user()->id;
                $grn_datas->save();

                $grn_id=$grn_datas->id;

                $rack_ids=$request->rack_id;

                foreach ($rack_ids as $key => $rack_id) {
                    $grn_heat_nos = new HeatNumber;
                    $grn_heat_nos->grnnumber_id =$grn_id;
                    $grn_heat_nos->heatnumber =$request->heatnumber[$key];
                    $grn_heat_nos->tc_no =$request->tc_no[$key];
                    $grn_heat_nos->rack_id =$rack_id;
                    $grn_heat_nos->lot_no =$request->lot_no[$key];
                    $grn_heat_nos->coil_no =$request->coil_no[$key];
                    $grn_heat_nos->coil_inward_qty =$request->coil_inward_qty[$key];
                    $grn_heat_nos->prepared_by = auth()->user()->id;
                    $grn_heat_nos->save();

                    $heat_no_id=$grn_heat_nos->id;

                    $grn_qc=new GrnQuality;
                    $grn_qc->grnnumber_id =$grn_id;
                    $grn_qc->heat_no_id =$heat_no_id;
                    $grn_qc->rack_id =$rack_id;
                    $grn_qc->inspected_qty =$request->coil_inward_qty[$key];
                    $grn_qc->prepared_by = auth()->user()->id;
                    $grn_qc->save();
                }
                DB::commit();
                return back()->withSuccess('GRN is Created Successfully!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            //dd($th->getMessage());
            return response()->json(['errors' => $th->getMessage()]);
            // return redirect()->back()->withErrors($th->getMessage());

        }
    }

    public function rmIssuanceData(){
        $d12Datas=TransDataD12::with(['partmaster','currentprocessmaster','currentproductprocessmaster','current_rcmaster','previous_rcmaster','heat_nomaster','grndata','rm_master'])->where('process_id','=',3)->orderBy('id', 'DESC')->get();
        // dd($d12Datas);
        // $d11Datas=DB::table('trans_data_d12_s as a')
        // ->join('heat_numbers AS b', 'a.heat_id', '=', 'b.id')
        // ->join('raw_materials AS c', 'a.rm_id', '=', 'c.id')
        // ->join('route_masters AS d', 'a.rc_id', '=', 'd.id')
        // ->join('route_masters AS e', 'a.previous_rc_id', '=', 'e.id')
        // ->select('d.rc_id as rc_no','a.open_date','a.rm_issue_qty','e.rc_id as previous_rc_no','a.status','b.id as heat_id','b.heatnumber','b.tc_no','b.coil_no','c.name as rm_desc')
        // ->where('a.process_id','=',3)
        // ->orderBy('a.id', 'DESC')
        // ->get();
        // dd($d11Datas);
        return view('rm_issuance.index',compact('d12Datas'));
    }

    public function rmIssuance(){
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');
		$rc="A";
		$current_rcno=$rc.$current_year;
        $process=ItemProcesmaster::where('operation','=','Store')->where('status','=',1)->first();
        $process_id=$process->id;
        $count1=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->get()->count();
        // $count=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->get()->count();
        if ($count1 > 0) {
            // $rc_data=TransDataD11::where('rc_no','LIKE','%'.$current_rcno.'%')->orderBy('rc_no', 'DESC')->first();
            $rc_data=RouteMaster::where('process_id','=',$process_id)->where('rc_id','LIKE','%'.$current_rcno.'%')->orderBy('rc_id', 'DESC')->first();
            $rcnumber=$rc_data['rc_id']??NULL;
            $old_rcnumber=str_replace("A","",$rcnumber);
            $old_rcnumber_data=str_pad($old_rcnumber+1,9,0,STR_PAD_LEFT);
            $new_rcnumber='A'.$old_rcnumber_data;
        }else{
            $str='000001';
            $new_rcnumber=$current_rcno.$str;
        }
        // $grnDatas=GRNInwardRegister::where('status','=',0)->select('id','grnnumber')->get();
        $grnDatas=DB::table('g_r_n_inward_registers as a')
        ->join('heat_numbers AS b', 'a.id', '=', 'b.grnnumber_id')
        ->join('route_masters AS n', 'a.grnnumber', '=', 'n.id')
        ->select('a.id as id','n.rc_id as grnnumber')
        ->where('b.status','=',1)
        ->where('a.status','=',0)
        ->groupBy('a.id')
        ->get();
        // dd($grnDatas);
        // dd($new_rcnumber);
        return view('rm_issuance.create',compact('grnDatas','new_rcnumber','current_date'));
    }

    public function grnRmFetchData(Request $request){
        // dd($request->all());
        $grn_id=$request->grn_id;
        $heatnNoDatas=DB::table('g_r_n_inward_registers as a')
        ->join('heat_numbers AS b', 'a.id', '=', 'b.grnnumber_id')
        ->select('a.id as grn_id','a.grnnumber','b.id as heat_id','b.heatnumber')
        ->where('b.status','=',1)
        ->where('a.status','=',0)
        ->where('a.id','=',$grn_id)
        ->get();

        $rmDatas=DB::table('g_r_n_inward_registers as a')
        ->join('p_o_product_details AS b', 'a.p_o_product_id', '=', 'b.id')
        ->join('supplier_products as c', 'b.supplier_product_id', '=', 'c.id')
        ->join('raw_materials as d', 'c.raw_material_id', '=', 'd.id')
        ->join('bom_masters as e', 'e.rm_id', '=', 'd.id')
        ->join('child_product_masters as f', 'e.child_part_id', '=', 'f.id')
        ->join('mode_of_units as g', 'c.uom_id', '=', 'g.id')
        ->select('a.grnnumber','d.id as rm_id','d.name as rm_desc','f.id as part_id','f.child_part_no as part_no','c.uom_id','g.name as uom_name')
        ->where('a.status','=',0)
        ->where('a.id','=',$grn_id)
        ->get();

        // dd($heatnNoDatas2);
        // dd($rmDatas);
        $heat_no='<option value="" selected>Select The Heat No</option>';
        foreach ($heatnNoDatas as $key => $heatnNoData) {
            $heat_no.='<option value="'.$heatnNoData->heatnumber.'">'.$heatnNoData->heatnumber.'</option>';
        }
        $uom='<option value="'.$rmDatas[0]->uom_id.'">'.$rmDatas[0]->uom_name.'</option>';
        $rm='<option value="'.$rmDatas[0]->rm_id.'">'.$rmDatas[0]->rm_desc.'</option>';
        $part='<option value="" selected>Select The RM</option>';
        foreach ($rmDatas as $key => $rmData) {
            $part.='<option value="'.$rmData->part_id.'">'.$rmData->part_no.'</option>';
        }
        return response()->json(['rm'=>$rm,'part'=>$part,'heat_no'=>$heat_no,'uom'=>$uom]);
    }

    public function grnHeatFetchData(Request $request){
        $grn_id=$request->grn_id;
        $heat_id=$request->heat_id;
        $count=HeatNumber::where('heatnumber','=',$heat_id)->where('status','=',1)->get()->count();
        if($count>0){
            $heatDatas=HeatNumber::where('heatnumber','=',$heat_id)->where('status','=',1)->get();
            $coil_no='<option value="" selected>Select The Coil No</option>';
            foreach ($heatDatas as $key => $heatData) {
                $coil_no.='<option value="'.$heatData->coil_no.'">'.$heatData->coil_no.'</option>';
            }
            return response()->json(['count'=>$count,'coil_no'=>$coil_no]);
        }else{
            return response()->json(['count'=>0]);
        }
    }

    public function grnCoilFetchData(Request $request){
        $grn_id=$request->grn_id;
        $heat_no_id=$request->heat_id;
        $coil_no=$request->coil_no;
        $count=HeatNumber::where('heatnumber','=',$heat_no_id)->where('coil_no','=',$coil_no)->first()->count();
        if($count>0){
            $heatDatas=HeatNumber::where('heatnumber','=',$heat_no_id)->where('coil_no','=',$coil_no)->first();
            $heat_id=$heatDatas->id;
            $tc_no=$heatDatas->tc_no;
            $lot_no=$heatDatas->lot_no;
            $count2=GrnQuality::where('heat_no_id','=',$heat_id)->where('grnnumber_id','=',$grn_id)->first()->count();
            if ($count2>0) {
                $grnQcDatas=GrnQuality::where('heat_no_id','=',$heat_id)->where('grnnumber_id','=',$grn_id)->first();
                $avl_qty=(($grnQcDatas->approved_qty)-($grnQcDatas->issue_qty)-($grnQcDatas->return_qty));
                $grn_qc_id=$grnQcDatas->id;
            }else{
                $avl_qty=0;
            }
        return response()->json(['count'=>$count,'avl_qty'=>$avl_qty,'grn_qc_id'=>$grn_qc_id,'heat_id'=>$heat_id,'tc_no'=>$tc_no,'lot_no'=>$lot_no]);
        }else{
        return response()->json(['count'=>0]);
        }

    }
    public function storeData(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $process=ItemProcesmaster::where('operation','=','Store')->where('status','=',1)->first();
            // dd($process);
            $process_id=$process->id;

            $rcMaster=new RouteMaster;
            $rcMaster->create_date=$request->rc_date;
            $rcMaster->process_id=$process_id;
            $rcMaster->rc_id=$request->rc_no;
            $rcMaster->prepared_by=auth()->user()->id;
            $rcMaster->save();

            // stock add in grn inward table
            $grnInwardDatas=GRNInwardRegister::find($request->grnnumber);
            $total_issue_qty=(($grnInwardDatas->issued_qty)+($request->issue_qty));
            $grnInwardDatas->issued_qty = $total_issue_qty;
            $grnInwardDatas->updated_by = auth()->user()->id;
            $grnInwardDatas->update();

            // dd($grnInwardDatas->grnnumber);
            $rcMasterData=RouteMaster::where('rc_id','=',$request->rc_no)->where('process_id','=',$process_id)->first();
            $rc_id=$rcMasterData->id;
            // dd($rcMasterData);

            // stock add in grn quality table
            $grnqcDatas=GrnQuality::find($request->grn_qc_id);
            $grnqcDatas->issue_qty=$request->issue_qty;
            $grnqcDatas->updated_by = auth()->user()->id;
            $grnqcDatas->update();



            // dd($total_issue_qty);
            $part_id=$request->part_id;
            $productProcess=DB::table('item_procesmasters as a')
            ->join('product_process_masters AS b', 'a.id', '=', 'b.process_master_id')
            ->join('child_product_masters as c', 'b.part_id', '=', 'c.id')
            ->select('b.process_master_id as process_id','b.process_order_id','b.id')
            ->where('a.operation','=','Store')
            ->where('a.status','=',1)
            ->where('c.id','=',$part_id)
            ->first();
            // dd($productProcess);

            $current_processproduct_id=$productProcess->id;
            $current_process_id=$productProcess->process_id;
            $current_order_id=$productProcess->process_order_id;

            $next_productProcess=DB::table('item_procesmasters as a')
            ->join('product_process_masters AS b', 'a.id', '=', 'b.process_master_id')
            ->join('child_product_masters as c', 'b.part_id', '=', 'c.id')
            ->select('b.process_master_id as process_id','b.process_order_id','b.id')
            ->where('a.operation_type','=','STOCKING POINT')
            ->where('b.process_order_id','>',$current_order_id)
            ->where('a.status','=',1)
            ->where('b.status','=',1)
            ->where('c.id','=',$part_id)
            ->first();
            // dd($next_productProcess);

            $next_processproduct_id=$next_productProcess->id;
            $next_process_id=$next_productProcess->process_id;
            $next_order_id=$next_productProcess->process_order_id;
            // $productProcess=ProductProcessMaster::where('part_id','=',$part_id)->where('status','=',1)->where('process_order_id','=',1)->first();
            // $nextproductProcess=ProductProcessMaster::where('part_id','=',$part_id)->where('status','=',1)->where('process_order_id','=',2)->first();
            // $current_processproduct_id=$productProcess->id;
            // $current_process_id=$productProcess->process_master_id;


            // $next_processproduct_id=$nextproductProcess->id;
            // $next_process_id=$nextproductProcess->process_master_id;

            $d11Datas=new TransDataD11;
            $d11Datas->open_date=$request->rc_date;
            $d11Datas->rc_id=$rc_id;
            $d11Datas->part_id=$request->part_id;
            $d11Datas->process_id=$current_process_id;
            $d11Datas->product_process_id=$current_processproduct_id;
            $d11Datas->next_process_id=$next_process_id;
            $d11Datas->next_product_process_id=$next_processproduct_id;
            $d11Datas->process_issue_qty=$request->issue_qty;
            $d11Datas->prepared_by = auth()->user()->id;
            $d11Datas->save();

            $d12Datas=new TransDataD12;
            $d12Datas->open_date=$request->rc_date;
            $d12Datas->rc_id=$rc_id;
            $d12Datas->previous_rc_id=$grnInwardDatas->grnnumber;
            $d12Datas->part_id=$request->part_id;
            $d12Datas->rm_id=$request->rm_id;
            $d12Datas->process_id=$current_process_id;
            $d12Datas->product_process_id=$current_processproduct_id;
            $d12Datas->rm_issue_qty=$request->issue_qty;
            $d12Datas->grn_id=$request->grnnumber;
            $d12Datas->heat_id=$request->heat_id;
            $d12Datas->coil_no=$request->coil_no;
            $d12Datas->prepared_by = auth()->user()->id;
            $d12Datas->save();

            $d13Datas=new TransDataD13;
            $d13Datas->rc_id=$rc_id;
            $d13Datas->previous_rc_id=$grnInwardDatas->grnnumber;
            $d13Datas->prepared_by = auth()->user()->id;
            $d13Datas->save();

            DB::commit();
            return back()->withSuccess('RM Issued is Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGRNInwardRegisterRequest $request, GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }
}
