<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\RackStockmaster;
use App\Models\Rackmaster;
use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
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
        $rackmaster_datas=Rackmaster::with(['rackstockmaster','category','material'])->get();
        // dd($rackmaster_datas);
        $available_stock=50;
        return view('rack_master.index',compact('rackmaster_datas','available_stock'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $rackstockmasters=RackStockmaster::where('status','=',1)->get();
        $categories=RawMaterialCategory::where('status','=',1)->get();
        // dd($categories);
        return view('rack_master.create',compact('rackstockmasters','categories'));
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
