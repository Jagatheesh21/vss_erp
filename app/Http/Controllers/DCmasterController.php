<?php

namespace App\Http\Controllers;

use App\Models\DcMaster;
use App\Http\Requests\StoreDcMasterRequest;
use App\Http\Requests\UpdateDcMasterRequest;

class DcMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dc_master.calculations');

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
    public function store(StoreDcMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DcMaster $dCmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DcMaster $dCmaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDcMasterRequest $request, DCmaster $dCmaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DcMaster $dCmaster)
    {
        //
    }
}
