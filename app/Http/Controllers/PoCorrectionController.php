<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\PoCorrection;
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
            $pocorrection_data->reason = $request->reason;
            $pocorrection_data->prepared_by = auth()->user()->id;
            $pocorrection_data->save();
            DB::commit();
            return redirect()->route('pocorrection.index')->withSuccess('PO Correction is Requested Successfully!');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoCorrection $poCorrection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoCorrectionRequest $request, PoCorrection $poCorrection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PoCorrection $poCorrection)
    {
        //
    }
}
