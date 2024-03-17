<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DcTransactionDetails;
use App\Models\DcMaster;
use App\Models\BomMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\ProductProcessMaster;
use App\Models\ChildProductMaster;
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DcPrint;
use App\Http\Requests\StoreDcPrintRequest;
use App\Http\Requests\UpdateDcPrintRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class DcPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dcprintDatas=DcPrint::with('dctransaction')->where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','!=',0)->groupBy('s_no') ->get();
        return view('dc_print.index',compact('dcprintDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dcprintSnos=DcPrint::with('dctransaction')->where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','!=',0) ->select('s_no')->orderBy('id','DESC')->first();
        $dcsupplierDatas=DcMaster::with('supplier')->where('status','=',1)->get();
        $sno=$dcprintSnos->s_no??NULL;
        // dd($sno);
        $dc_sno=$sno+1;
        // dd($dc_sno);
        return view('dc_print.create',compact('dcsupplierDatas','dc_sno'));
    }



    public function dcMultiPrintData(Request $request){
        // dd($request->all());
        $s_no=$request->s_no;
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.s_no','=',$s_no)
        ->get();
        // dd($dc_transactionDatas);

        $table="";
        foreach ($dc_transactionDatas as $key => $dc_transactionData) {
            $table.='<tr class="tr_'.$dc_transactionData->dc_print_id.'">'.
            '<td>'.$dc_transactionData->dc_no.'</td>'.
            '<td>'.$dc_transactionData->issue_date.'</td>'.
            '<td>'.$dc_transactionData->part_no.'</td>'.
            '<td>'.$dc_transactionData->issue_qty.'</td>'.
            '<td>'.$dc_transactionData->uom.'</td>'.
            '<td>'.$dc_transactionData->unit_rate.'</td>'.
            '<td>'.$dc_transactionData->total_rate.'</td>'.
            '</tr>';
        }
        return response()->json(['table'=>$table]);

    }

    public function dcMultiPdfData(Request $request){
        $s_no=$request->s_no;
        $count1=DcPrint::where('s_no','=',$s_no)->count();
        // dd($count);
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->join('item_procesmasters as g', 'c.operation_id', '=', 'g.id')
        ->join('suppliers as h', 'c.supplier_id', '=', 'h.id')
        ->select('c.operation_desc','c.hsnc','b.vehicle_no','b.trans_mode','a.id as dc_print_id','h.name as supplier_name','h.address as supplier_address','h.address1 as supplier_address1','h.city as supplier_city','h.state as supplier_state','h.pincode as supplier_pincode','h.state_code as supplier_state_code','h.gst_number as supplier_gst_number','a.s_no','b.issue_wt','c.operation_id','g.operation','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.s_no','=',$s_no)
        ->get();
        $count=21;

        $totalData=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')->where('a.s_no','=',$s_no)->select(DB::raw('(SUM(total_rate)) as sum_rate'),DB::raw('(SUM(issue_qty)) as sum_qty'))->get();
        // dd($totalData);
        $pdf = Pdf::loadView('dc_print.dcmultipdf',compact('dc_transactionDatas','totalData','count'))->setPaper('a4', 'portrait');
        // $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream();
        // return view('dc_print.dcmultipdf',compact('dc_transactionDatas'));
    }
    public function dcSupplierPrintData(Request $request){
        // dd($request->all());
        $supplier_id=$request->supplier_id;
        $dc_transactionDatas=DB::table('dc_prints as a')
        ->join('dc_transaction_details AS b', 'a.dc_id', '=', 'b.id')
        ->join('dc_masters as c', 'b.dc_master_id', '=', 'c.id')
        ->join('route_masters as d', 'b.rc_id', '=', 'd.id')
        ->join('mode_of_units as e', 'b.uom_id', '=', 'e.id')
        ->join('product_masters as f', 'c.part_id', '=', 'f.id')
        ->select('a.id as dc_print_id','b.id as dc_id','d.id as rc_id','d.rc_id as dc_no','b.issue_date','f.id as part_id','f.part_no','b.uom_id','e.name as uom','b.issue_qty','b.unit_rate','b.total_rate')
        ->where('a.print_status','=',0)
        ->where('a.s_no','=',0)
        ->where('c.supplier_id','=',$supplier_id)
        ->get();
        // dd($dc_transactionDatas);

        $table="";
        foreach ($dc_transactionDatas as $key => $dc_transactionData) {
            $table.='<tr class="tr_'.$dc_transactionData->dc_print_id.'">'.
            '<td><input type="checkbox" class="form-check-input sub_id" name="sub_id[]" data-id="'.$dc_transactionData->dc_print_id.'" value="'.$dc_transactionData->dc_print_id.'"></td>'.
            '<td><select name="dc_id[]" class="form-control bg-light dc_id" readonly id="dc_id"><option value="'.$dc_transactionData->dc_id.'">'.$dc_transactionData->dc_no.'</option></select></td>'.
            '<td><input type="date" name="issue_date[]"  class="form-control bg-light issue_date" readonly  id="issue_date" value="'.$dc_transactionData->issue_date.'"></td>'.
            '<td><select name="part_id[]" class="form-control bg-light part_id" readonly id="part_id"><option value="'.$dc_transactionData->part_id.'">'.$dc_transactionData->part_no.'</option></select></td>'.
            '<td><input type="number" name="issue_qty[]"  class="form-control bg-light issue_qty" readonly  id="issue_qty" value="'.$dc_transactionData->issue_qty.'"></td>'.
            '<td><select name="uom_id[]" class="form-control bg-light uom_id"  id="uom_id"><option value="'.$dc_transactionData->uom_id.'">'.$dc_transactionData->uom.'</option></select></td>'.
            '<td><input type="number" name="unit_rate[]" readonly class="form-control bg-light unit_rate"   id="unit_rate" value="'.$dc_transactionData->unit_rate.'"></td>'.
            '<td><input type="number" name="total_rate[]" readonly  class="form-control bg-light total_rate"   id="total_rate" value="'.$dc_transactionData->total_rate.'"></td>'.
            '</tr>';
        }
        return response()->json(['table'=>$table]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcPrintRequest $request)
    {
        //
        dd($request->all());
        $sub_datas=$request->sub_id;
        foreach ($sub_datas as $key => $sub_data) {
            $dcprintDatas=DcPrint::find($sub_data);
            $dcprintDatas->s_no=$request->s_no;
            $dcprintDatas->print_status=1;
            $dcprintDatas->update();
            DB::commit();
        }
        return redirect()->route('dcprint.index')->withSuccess('Multi Delivery Challan Created Successfully!');
    }

    public function multiDCReceive()
    {
        $multiDCDatas=DcPrint::where('from_unit','=',1)->where('s_no','!=',0)->where('print_status','=',1)->where('status','=',1)->groupBy('s_no') ->get();
        dd($multiDCDatas);
    }

    /**
     * Display the specified resource.
     */
    public function show(DcPrint $dcprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DcPrint $dcprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDcPrintRequest $request, DcPrint $dcprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DcPrint $dcprint)
    {
        //
    }
}
