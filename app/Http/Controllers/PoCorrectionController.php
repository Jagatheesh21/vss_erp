<?php

namespace App\Http\Controllers;

use App\Models\PoCorrection;
use App\Http\Requests\StorePoCorrectionRequest;
use App\Http\Requests\UpdatePoCorrectionRequest;

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
        dd($request);
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
