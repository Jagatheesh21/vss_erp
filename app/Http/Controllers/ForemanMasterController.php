<?php

namespace App\Http\Controllers;

use App\Models\ForemanMaster;
use App\Http\Requests\StoreForemanMasterRequest;
use App\Http\Requests\UpdateForemanMasterRequest;

class ForemanMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $foremanData=ForemanMaster::all();
        return view('',compact('foremanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreForemanMasterRequest $request)
    {
        //
        dd($request->all());
        $data=$request->except('_token');
        $foremanData=ForemanMaster::create($data);
        dd("ok");
    }

    /**
     * Display the specified resource.
     */
    public function show(ForemanMaster $foremanMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForemanMaster $foremanMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateForemanMasterRequest $request, ForemanMaster $foremanMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForemanMaster $foremanMaster)
    {
        //
    }
}
