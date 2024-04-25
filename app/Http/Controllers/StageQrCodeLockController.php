<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\StageQrCodeLock;
use App\Http\Requests\StoreStageQrCodeLockRequest;
use App\Http\Requests\UpdateStageQrCodeLockRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StageQrCodeLockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $qrlockDatas=StageQrCodeLock::all();
        // dd($qrlockDatas);
        return view('qrcodelock.index',compact('qrlockDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('qrcodelock.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStageQrCodeLockRequest $request)
    {
        //
        // dd($request->all());
        DB::beginTransaction();
        try {
            $qrlock=new StageQrCodeLock;
            $qrlock->stage=$request->stage;
            $qrlock->activity=$request->activity;
            $qrlock->prepared_by = auth()->user()->id;
            $qrlock->save();
            DB::commit();
            return redirect()->route('stageqrcodelock.index')->withSuccess('QR Code Lock Is Created Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StageQrCodeLock $stageqrcodelock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StageQrCodeLock $stageqrcodelock)
    {
        //
        // dd($stageqrcodelock);
        return view('qrcodelock.edit',compact('stageqrcodelock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStageQrCodeLockRequest $request, StageQrCodeLock $stageqrcodelock)
    {
        //
        // dd($request->all());
        DB::beginTransaction();
        try {
            $stageqrcodelock->stage=$request->stage;
            $stageqrcodelock->activity=$request->activity;
            $stageqrcodelock->status=$request->status;
            $stageqrcodelock->updated_by = auth()->user()->id;
            $stageqrcodelock->updated_at = Carbon::now();
            $stageqrcodelock->update();
            DB::commit();
            return redirect()->route('stageqrcodelock.index')->withSuccess('QR Code Lock Is Updated Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StageQrCodeLock $stageqrcodelock)
    {
        //
    }
}
