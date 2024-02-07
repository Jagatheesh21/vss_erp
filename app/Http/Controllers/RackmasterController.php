<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\RackStockmaster;
use App\Models\Rackmaster;
use App\Http\Requests\StoreRackmasterRequest;
use App\Http\Requests\UpdateRackmasterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class RackmasterController extends Controller
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
    public function store(StoreRackmasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Rackmaster $rackmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rackmaster $rackmaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRackmasterRequest $request, Rackmaster $rackmaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rackmaster $rackmaster)
    {
        //
    }
}
