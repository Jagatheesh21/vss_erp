<?php

namespace App\Http\Controllers;

use App\Models\FinalQcInspection;
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
        dd($request->all());
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
