<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BomMaster;
Use App\Models\RouteMaster;
Use App\Models\Supplier;
use App\Models\ItemProcesmaster;
use App\Models\ProductMaster;
use App\Models\ProductProcessMaster;
use App\Models\ChildProductMaster;
use App\Models\CustomerMaster;
use App\Models\CustomerPoMaster;
use App\Models\CustomerProductMaster;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\TransDataD13;
use App\Models\InvoiceDetails;
use App\Models\InvoicePrint;
use App\Models\InvoiceCorrectionMaster;
use App\Models\InvoiceCorrectionDetail;
use App\Http\Requests\StoreInvoiceCorrectionMasterRequest;
use App\Http\Requests\UpdateInvoiceCorrectionMasterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Carbon\Carbon;
use Auth;

class InvoiceCorrectionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $correctionMasterDatas=InvoiceCorrectionMaster::with('invoicedetails','preparedusers','approvedusers')->orderBy('id','DESC')->get();
        // dd($correctionMasterDatas);
        return view('invoice_correction.index',compact('correctionMasterDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $invoiceDetails=InvoiceDetails::with('rcmaster')->where('status','=',1)->get();
        // dd($invoiceDetails);
        return view('invoice_correction.create',compact('invoiceDetails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceCorrectionMasterRequest $request)
    {
        //
        // dd($request->all());
        date_default_timezone_set("Asia/Kolkata");
        $current_date=date('Y-m-d');
        // dd($current_date);
        $correctionMasterData=new InvoiceCorrectionMaster;
        $correctionMasterData->correction_request_date=$current_date;
        $correctionMasterData->invoice_id=$request->invoice_number;
        $correctionMasterData->qty=$request->qty;
        $correctionMasterData->request_reason=$request->request_reason;
        $correctionMasterData->prepared_by=auth()->user()->id;
        $correctionMasterData->save();

        $invoiceDetails=InvoiceDetails::find($request->invoice_number);
        $invoiceDetails->status=0;
        $invoiceDetails->updated_by=auth()->user()->id;
        $invoiceDetails->updated_at = Carbon::now();
        $invoiceDetails->update();

        return redirect()->route('invoicecorrectionmaster.index')->withSuccess('Invoice Correction Request is Submitted Successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceCorrectionMaster $invoicecorrectionmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // EDIT
        // dd($id);
        $invoicecorrectionmasterDatas=InvoiceCorrectionMaster::with('invoicedetails','preparedusers','approvedusers')->find($id);
        // dd($invoicecorrectionmasterDatas);
        return view('invoice_correction.edit',compact('invoicecorrectionmasterDatas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceCorrectionMasterRequest $request, InvoiceCorrectionMaster $invoicecorrectionmaster)
    {
        //
        // dd($invoicecorrectionmaster);
        // dd($request->all());
        date_default_timezone_set("Asia/Kolkata");
        $current_date=date('Y-m-d');

        if ($request->status==0) {
            return redirect()->route('invoicecorrectionmaster.index')->withMessage('Sorry..Please Try Another Status..!');
        }else {
                    // dd($current_date);
            $invoicecorrectionmaster->approved_by=auth()->user()->id;
            $invoicecorrectionmaster->approved_date=$current_date;
            $invoicecorrectionmaster->status=$request->status;
            $invoicecorrectionmaster->approved_reason=$request->approved_reason;
            $invoicecorrectionmaster->updated_by=auth()->user()->id;
            $invoicecorrectionmaster->updated_at= Carbon::now();
            $invoicecorrectionmaster->update();

            $invoice_id=$invoicecorrectionmaster->invoice_id;

            $invoiceDetails=InvoiceDetails::find($invoice_id);
            $invoiceDetails->status=$request->status;
            $invoiceDetails->updated_by=auth()->user()->id;
            $invoiceDetails->updated_at= Carbon::now();
            $invoiceDetails->update();

        if ($request->status==3) {
            $invoicecorrectionData=new InvoiceCorrectionDetail;
            $invoicecorrectionData->correction_master_id=$invoicecorrectionmaster->id;
            $invoicecorrectionData->invoice_no=$invoiceDetails->invoice_no;
            $invoicecorrectionData->invoice_date=$invoiceDetails->invoice_date;
            $invoicecorrectionData->invoice_time=$invoiceDetails->invoice_time;
            $invoicecorrectionData->cus_product_id=$invoiceDetails->cus_product_id;
            $invoicecorrectionData->part_id=$invoiceDetails->part_id;
            $invoicecorrectionData->part_hsnc=$invoiceDetails->part_hsnc;
            $invoicecorrectionData->cus_po_id=$invoiceDetails->cus_po_id;
            $invoicecorrectionData->qty=$invoiceDetails->qty;
            $invoicecorrectionData->uom_id=$invoiceDetails->uom_id;
            $invoicecorrectionData->part_per=$invoiceDetails->part_per;
            $invoicecorrectionData->currency_id=$invoiceDetails->currency_id;
            $invoicecorrectionData->packing_charge=$invoiceDetails->packing_charge;
            $invoicecorrectionData->part_rate=$invoiceDetails->part_rate;
            $invoicecorrectionData->cgst=$invoiceDetails->cgst;
            $invoicecorrectionData->sgst=$invoiceDetails->sgst;
            $invoicecorrectionData->igst=$invoiceDetails->igst;
            $invoicecorrectionData->tcs=$invoiceDetails->tcs;
            $invoicecorrectionData->basic_value=$invoiceDetails->basic_value;
            $invoicecorrectionData->packing_charge_amt=$invoiceDetails->packing_charge_amt;
            $invoicecorrectionData->cgstamt=$invoiceDetails->cgstamt;
            $invoicecorrectionData->sgstamt=$invoiceDetails->sgstamt;
            $invoicecorrectionData->igstamt=$invoiceDetails->igstamt;
            $invoicecorrectionData->tcsamt=$invoiceDetails->tcsamt;
            $invoicecorrectionData->invtotal=$invoiceDetails->invtotal;
            $invoicecorrectionData->cori=$invoiceDetails->cori;
            $invoicecorrectionData->trans_mode=$invoiceDetails->trans_mode;
            $invoicecorrectionData->vehicle_no=$invoiceDetails->vehicle_no;
            $invoicecorrectionData->sup=$invoiceDetails->sup;
            $invoicecorrectionData->ok=$invoiceDetails->ok;
            $invoicecorrectionData->type=$invoiceDetails->type;
            $invoicecorrectionData->document_type=$invoiceDetails->document_type;
            $invoicecorrectionData->reverse_charge=$invoiceDetails->reverse_charge;
            $invoicecorrectionData->igst_on_intra=$invoiceDetails->igst_on_intra;
            $invoicecorrectionData->remarks=$invoiceDetails->remarks;
            $invoicecorrectionData->remarks1=$invoiceDetails->remarks1;
            $invoicecorrectionData->remarks2=$invoiceDetails->remarks2;
            $invoicecorrectionData->remarks3=$invoiceDetails->remarks3;
            $invoicecorrectionData->remarks4=$invoiceDetails->remarks4;
            $invoicecorrectionData->status=$invoiceDetails->status;
            $invoicecorrectionData->prepared_by=$invoiceDetails->prepared_by;
            $invoicecorrectionData->updated_by=$invoiceDetails->updated_by;
            $invoicecorrectionData->save();

            // dd($request->status);
            $invoicePrint=InvoicePrint::where('invoice_no',$invoiceDetails->invoice_no)->first();
            $invoicePrint->status=$request->status;
            $invoicePrint->updated_at= Carbon::now();
            $invoicePrint->update();


            $t12Datas=TransDataD12::where('rc_id','=',$invoiceDetails->invoice_no)->where('process_id','=',22)->select('previous_rc_id','issue_qty')->get();
            // dd($t12Datas);
            foreach ($t12Datas as $t12Data) {
                $previous_rc_id=$t12Data->previous_rc_id;
                $issue_qty=$t12Data->issue_qty;

                $t11Datas=TransDataD11::where('rc_id','=',$previous_rc_id)->where('next_process_id','=',22)->first();
                $old_issue_qty=$t11Datas->issue_qty;
                $current_issue_qty=(($old_issue_qty)-($issue_qty));
                $t11Datas->issue_qty=$current_issue_qty;
                $t11Datas->updated_by=auth()->user()->id;
                $t11Datas->updated_at= Carbon::now();
                $t11Datas->update();

                $oldt12Datas=TransDataD12::where('rc_id','=',$invoiceDetails->invoice_no)->where('previous_rc_id','=',$previous_rc_id)->where('process_id','=',22)->select('previous_rc_id','issue_qty')->first();
                $oldt12Datas->delete();

                $oldt13Datas=TransDataD13::where('rc_id','=',$invoiceDetails->invoice_no)->where('previous_rc_id','=',$previous_rc_id)->first();
                $oldt13Datas->delete();
            }
        }
        return redirect()->route('invoicecorrectionmaster.index')->withSuccess('Your Data is Submitted Successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceCorrectionMaster $invoicecorrectionmaster)
    {
        //
    }
}
