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
