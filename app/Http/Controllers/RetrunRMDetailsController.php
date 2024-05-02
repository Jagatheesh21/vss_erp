<?php

namespace App\Http\Controllers;

use App\Models\RetrunRMDetails;
use App\Http\Requests\StoreRetrunRMDetailsRequest;
use App\Http\Requests\UpdateRetrunRMDetailsRequest;

class RetrunRMDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $returnrmDatas=RetrunRMDetails::all();
        return view('rm_issuance.return_rm',compact('returnrmDatas'));
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
