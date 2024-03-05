<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\PoCorrection;
use App\Models\User;
use App\Models\PODetail;
use App\Models\POProductDetail;
use App\Http\Requests\StorePoCorrectionRequest;
use App\Http\Requests\UpdatePoCorrectionRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PoCorrectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pocorrection_datas =PoCorrection::with(['podetails'])->orderBy('id', 'DESC')->get();
        $user_datas=User::get();
        // dd($po_correction_datas);
        return view('po_correction.index',compact('pocorrection_datas','user_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePoCorrectionRequest $request)
    {
        //
        // dd($request);
        DB::beginTransaction();
        try {
            $pocorrection_data = new PoCorrection;
            $pocorrection_data->po_id = $request->po_id;
            $pocorrection_data->po_corrections_date = $request->po_corrections_date;
            $pocorrection_data->request_reason = $request->request_reason;
            $pocorrection_data->prepared_by = auth()->user()->id;
            $pocorrection_data->save();

            DB::commit();
            return redirect()->route('po-correction.index')->withSuccess('PO Correction is Requested Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PoCorrection $poCorrection)
    {
        //
    }

    public function approval(Request $request){
        $id=$request->id;
        $po_correction_data=PoCorrection::with(['podetails'])->where('id','=',$id)->get();
        $po_id=$po_correction_data[0]->po_id;
        $correction_id=$po_correction_data[0]->id;
        $po_datas=PODetail::with(['supplier','rcmaster'])->where('id','=',$po_id)->where('status','!=',1)->get();
        $total_rate=POProductDetail::where('po_id','=',$po_id)->sum('rate');
        dd($po_datas);

        return view('po_correction.edit',compact('po_datas','total_rate'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoCorrection $poCorrection)
    {
        //
        $po_id=$poCorrection->po_id;
        $po_datas=PODetail::with(['supplier'])->where('id','=',$po_id)->get();
        $total_rate=POProductDetail::where('po_id','=',$po_id)->sum('rate');
        return view('po_correction.edit',compact('poCorrection','po_datas','total_rate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoCorrectionRequest $request, PoCorrection $poCorrection)
    {
        //
        // dd($request->all());
        // dd($request->id);
        // dd($poCorrection->id);
        DB::beginTransaction();
        try {
            $id=$request->id;
            if ($poCorrection->id==$id) {
                $pocorrection_data=PoCorrection::find($id);
                $pocorrection_data->po_id = $request->po_id;
                $pocorrection_data->approved_by = auth()->user()->id;
                $pocorrection_data->approved_date = $request->approved_date;
                $pocorrection_data->status = $request->status;
                $pocorrection_data->approve_reason = $request->approve_reason;
                $pocorrection_data->updated_by = auth()->user()->id;
                $pocorrection_data->update();

                $poDatas=PODetail::find($request->po_id);
                $poDatas->correction_status=$request->status;
                $poDatas->update();

                DB::commit();
                return redirect()->route('po-correction.index')->withSuccess('PO Correction is Status Submitted Successfully!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PoCorrection $poCorrection)
    {
        //
    }
}
