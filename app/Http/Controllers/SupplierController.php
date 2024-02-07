<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Currency;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suppliers = Supplier::get();
        return view('supplier.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('supplier.create');

    }

    public function suppliersdata(Request $request){
        $id=$request->id;
        $count = Supplier::where('supplier_code',$id)->get()->count();
        if ($count>0) {
            $suppliers = Supplier::where('supplier_code',$id)->get();
            $trans_mode='';
            $currency_id='';
            foreach ($suppliers as $key => $supplier) {
                $id=$supplier->id;
                $name=$supplier->name;
                $gst_number=$supplier->gst_number;
                $address=$supplier->address;
                $contact_number=$supplier->contact_number;
                $packing_charges=$supplier->packing_charges;
                $cgst=$supplier->cgst;
                $sgst=$supplier->sgst;
                $igst=$supplier->igst;
                $remarks=$supplier->remarks;
                $trans_mode .= '<option value="'.$supplier->trans_mode.'">'.$supplier->trans_mode.'</option>';
                $currency_data=Currency::find($supplier->currency_id);
                $currency_data->name;
                $currency_id .= '<option value="'.$supplier->currency_id.'" selected>'.$currency_data->name.'</option>';

            }
            return response()->json(['id'=>$id,'name'=>$name,'gst_number'=>$gst_number,'address'=>$address,'contact_number'=>$contact_number,'packing_charges'=>$packing_charges,'trans_mode'=>$trans_mode,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'remarks'=>$remarks,'currency_id'=>$currency_id,'count'=>$count]);
        }else {
            $currency_id='';
            $trans_mode = '<option value="BY ROAD">BY ROAD</option>';
            $trans_mode .= '<option value="BY COURIER">BY COURIER</option>';
            $currency_datas=Currency::get();
            foreach ($currency_datas as $key => $currency_data) {
                $currency_id .= '<option value="'.$currency_data->id.'">'.$currency_data->name.'</option>';

            }
            return response()->json(['count'=>$count,'trans_mode'=>$trans_mode,'currency_id'=>$currency_id,'supplier_code'=>$id]);
        }
        // return $id;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        //
        // dd($request);
        DB::beginTransaction();
        try {
            $supplier_data = new Supplier;
            $supplier_data->supplier_code = $request->supplier_code;
            $supplier_data->name = $request->name;
            $supplier_data->gst_number = $request->gst_number;
            $supplier_data->address = $request->address;
            $supplier_data->contact_person = $request->contact_person;
            $supplier_data->email = $request->email;
            $supplier_data->contact_number = $request->contact_number;
            $supplier_data->packing_charges = $request->packing_charges;
            $supplier_data->trans_mode = $request->trans_mode;
            $supplier_data->cgst = $request->cgst;
            $supplier_data->sgst = $request->sgst;
            $supplier_data->igst = $request->igst;
            $supplier_data->remarks = $request->remarks;
            $supplier_data->currency_id = $request->currency_id;
            $supplier_data->prepared_by = auth()->user()->id;
            $supplier_data->save();
            DB::commit();
            return redirect()->route('supplier.index')->withSuccess('Supplier Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
        dd($supplier);
        $currency_datas=Currency::get();
        return view('supplier.edit',compact('supplier','currency_datas'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
        // dd($supplier);
        DB::beginTransaction();
        try {
            $id=$request->id;
            $supplier_data=Supplier::find($id);
            $supplier_data->supplier_code = $request->supplier_code;
            $supplier_data->name = $request->name;
            $supplier_data->gst_number = $request->gst_number;
            $supplier_data->address = $request->address;
            $supplier_data->contact_number = $request->contact_number;
            $supplier_data->packing_charges = $request->packing_charges;
            $supplier_data->trans_mode = $request->trans_mode;
            $supplier_data->cgst = $request->cgst;
            $supplier_data->sgst = $request->sgst;
            $supplier_data->igst = $request->igst;
            $supplier_data->remarks = $request->remarks;
            $supplier_data->currency_id = $request->currency_id;
            $supplier_data->status = $request->status;
            $supplier_data->updated_by = auth()->user()->id;
            $supplier_data->update();
            DB::commit();
            return redirect()->route('supplier.index')->withSuccess('supplier Updated Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
