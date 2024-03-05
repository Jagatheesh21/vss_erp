<?php

namespace App\Http\Controllers;

use App\Models\CustomerMaster;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCustomerMasterRequest;
use App\Http\Requests\UpdateCustomerMasterRequest;

class CustomerMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customerDatas=CustomerMaster::all();
        return view('customer.index',compact('customerDatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $prepared_by = auth()->user()->id;
        return view('customer.create',compact('prepared_by'));
    }

    public function customersData(Request $request){
        // dd($request->all());
        $id=$request->id;
        $count = CustomerMaster::where('cus_code',$id)->get()->count();
        // dd($count);
        if ($count>0) {
            $customerDatas = CustomerMaster::where('cus_code',$id)->first();
            return response()->json(['cus_name'=>$customerDatas->cus_name,'cus_gst_number'=>$customerDatas->cus_gst_number,'cus_address'=>$customerDatas->cus_address,'cus_address1'=>$customerDatas->cus_address1,'cus_city'=>$customerDatas->cus_city,'cus_state'=>$customerDatas->cus_state,'cus_country'=>$customerDatas->cus_country,'cus_pincode'=>$customerDatas->cus_pincode,'delivery_cus_name'=>$customerDatas->delivery_cus_name,'delivery_cus_gst_number'=>$customerDatas->delivery_cus_gst_number,'delivery_cus_address'=>$customerDatas->delivery_cus_address,'delivery_cus_address1'=>$customerDatas->delivery_cus_address1,'delivery_cus_city'=>$customerDatas->delivery_cus_city,'delivery_cus_state'=>$customerDatas->delivery_cus_state,'delivery_cus_country'=>$customerDatas->delivery_cus_country,'delivery_cus_pincode'=>$customerDatas->delivery_cus_pincode,'supplier_vendor_code'=>$customerDatas->supplier_vendor_code,'supplytype'=>$customerDatas->supplytype,'count'=>$count]);
        }else {
            # code...
            return response()->json(['count'=>$count]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerMasterRequest $request)
    {
        //
        // dd($request->all());
        // dd($request->_token);
        DB::beginTransaction();
        try {
            $data=$request->except('_token');
            $cus_name=$request->cus_name;
            $cus_gst_number=$request->cus_gst_number;
            $delivery_cus_name=$request->delivery_cus_name;
            $delivery_cus_gst_number=$request->delivery_cus_gst_number;

            $count=CustomerMaster::where('cus_gst_number','=',$cus_gst_number)->where('cus_name','!=',$cus_name)->count();
            $count1=CustomerMaster::where('delivery_cus_gst_number','=',$delivery_cus_gst_number)->where('delivery_cus_name','!=',$delivery_cus_name)->count();
            // dd($count);
            if ($count>=1) {
                # code...
                return back()->withMessage('This GST Number Taken Already Another Customer.');
            }elseif ($count1>=1) {
                # code...
                return back()->withMessage('This GST Number Taken Already Another Customer.');
            }
            else {
                $customerData=CustomerMaster::create($data);
                DB::commit();
            // return redirect()->route('customermaster')->withSuccess('Part Received is Successfully!');

                return redirect()->route('customermaster.index')->withSuccess('Custmoer is Created Successfully!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
        // dd($data);

    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerMaster $customermaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerMaster $customermaster)
    {
        //
        // dd($customermaster);
        $updated_by = auth()->user()->id;
        return view('customer.edit',compact('updated_by','customermaster'));
    }

    public function customersEditData(Request $request){
        // dd($request->all());
        $cus_id=$request->cus_id;
        $cus_code=$request->cus_code;
        $count = CustomerMaster::where('cus_code',$cus_code)->where('id','!=',$cus_id)->get()->count();
        // dd($count);
        if ($count>0) {
            $customerDatas = CustomerMaster::where('cus_code',$cus_code)->where('id','!=',$cus_id)->first();
            return response()->json(['cus_name'=>$customerDatas->cus_name,'cus_gst_number'=>$customerDatas->cus_gst_number,'cus_address'=>$customerDatas->cus_address,'cus_address1'=>$customerDatas->cus_address1,'cus_city'=>$customerDatas->cus_city,'cus_state'=>$customerDatas->cus_state,'cus_country'=>$customerDatas->cus_country,'cus_pincode'=>$customerDatas->cus_pincode,'delivery_cus_name'=>$customerDatas->delivery_cus_name,'delivery_cus_gst_number'=>$customerDatas->delivery_cus_gst_number,'delivery_cus_address'=>$customerDatas->delivery_cus_address,'delivery_cus_address1'=>$customerDatas->delivery_cus_address1,'delivery_cus_city'=>$customerDatas->delivery_cus_city,'delivery_cus_state'=>$customerDatas->delivery_cus_state,'delivery_cus_country'=>$customerDatas->delivery_cus_country,'delivery_cus_pincode'=>$customerDatas->delivery_cus_pincode,'supplier_vendor_code'=>$customerDatas->supplier_vendor_code,'supplytype'=>$customerDatas->supplytype,'count'=>$count]);
        }else {
            # code...
            return response()->json(['count'=>$count]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerMasterRequest $request, CustomerMaster $customermaster)
    {
        //
        DB::beginTransaction();
        try {
            $data=$request->except('_token');
            $cus_name=$request->cus_name;
            $cus_gst_number=$request->cus_gst_number;
            $delivery_cus_name=$request->delivery_cus_name;
            $delivery_cus_gst_number=$request->delivery_cus_gst_number;
            $count=CustomerMaster::where('cus_gst_number','=',$cus_gst_number)->where('cus_name','!=',$cus_name)->count();
            $count1=CustomerMaster::where('delivery_cus_gst_number','=',$delivery_cus_gst_number)->where('delivery_cus_name','!=',$delivery_cus_name)->count();
            // dd($count);
            if ($count>=1) {
                # code...
                return redirect()->route('customermaster.index')->withMessage('This GST Number Taken Already Another Customer.');
            }elseif ($count1>=1) {
                # code...
                return redirect()->route('customermaster.index')->withMessage('This GST Number Taken Already Another Customer.');
            }
            else {
                $data1=$customermaster->update($data);
                DB::commit();
                return redirect()->route('customermaster.index')->withSuccess('Custmoer is Updated Successfully!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerMaster $customermaster)
    {
        //
    }
}
