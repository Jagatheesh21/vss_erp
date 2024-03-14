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
        $dcprintDatas=DcPrint::with('dctransaction')->where('from_unit','=',1) ->get();
        return view('dc_print.index',compact('dcprintDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dcprintSnos=DcPrint::with('dctransaction')->where('from_unit','=',1) ->select('s_no')->orderBy('id','DESC')->first();
        $dcprintDatas=DcPrint::with('dctransaction')->where('from_unit','=',1)->where('print_status','=',0)->orderBy('id','DESC')->get();
        $sno=$dcprintSnos??NULL;
        $dc_sno='DC-U1-'.($sno+1);
        dd($dc_sno);
        return view('dc_print.create',compact('dcprintDatas','dc_sno'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDcPrintRequest $request)
    {
        //
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
