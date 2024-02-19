<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\RawMaterial;
use App\Models\Rackmaster;
use App\Models\ModeOfUnit;
use App\Models\GRNInwardRegister;
use App\Models\GrnQuality;
use App\Models\PODetail;
use App\Models\POProductDetail;
use App\Models\HeatNumber;
use App\Http\Requests\StoreGRNInwardRegisterRequest;
use App\Http\Requests\UpdateGRNInwardRegisterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class GRNInwardRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//         //SELECT
//     a.grnnumber,
//     a.grndate,
//     b.ponumber,
//     d.name AS sc_name,
//     d.supplier_code AS sc_code,
//     f.name AS rm_category,
//     g.name AS rm_desc,
//     a.inward_qty
// FROM
//     g_r_n_inward_registers AS a
// INNER JOIN p_o_details AS b
// ON
//     a.po_id = b.id
// INNER JOIN p_o_product_details AS c
// ON
//     a.p_o_product_id = c.id
// INNER JOIN suppliers AS d
// ON
//     c.supplier_id = d.id
// INNER JOIN supplier_products AS e
// ON
//     c.supplier_product_id = e.id
// INNER JOIN raw_material_categories AS f
// ON
//     e.raw_material_category_id = f.id
// INNER JOIN raw_materials AS g
// ON
//     e.raw_material_id = g.id

        $inward_datas = DB::table('g_r_n_inward_registers as a')
            ->join('p_o_details AS b', 'a.po_id', '=', 'b.id')
            ->join('p_o_product_details AS c', 'a.p_o_product_id', '=', 'c.id')
            ->join('suppliers AS d', 'c.supplier_id', '=', 'd.id')
            ->join('supplier_products AS e', 'c.supplier_product_id', '=', 'e.id')
            ->join('raw_material_categories AS f', 'e.raw_material_category_id', '=', 'f.id')
            ->join('raw_materials AS g', 'e.raw_material_id', '=', 'g.id')
            ->select('a.id as id','a.grnnumber', 'a.grndate', 'b.ponumber','d.name AS sc_name','d.supplier_code AS sc_code','f.name AS rm_category','g.name AS rm_desc','a.inward_qty','a.approved_qty', 'a.onhold_qty', 'a.rejected_qty', 'a.issued_qty', 'a.return_qty', 'a.return_dc_qty', 'a.avl_qty', 'a.grn_close_date', 'a.approved_status', 'a.status')
            ->get();
        // dd($inward_datas);

        // $inward_datas=GRNInwardRegister::with(['podata','poproduct','rackmaster'])->get();
        return view('grn_inward.index',compact('inward_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date('Y-m-d');
        $current_year=date('Y');
		$rc="G";
		$current_rcno=$rc.$current_year;
        $count=GRNInwardRegister::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->get()->count();
        if ($count > 0) {
            $po_data=GRNInwardRegister::where('grnnumber','LIKE','%'.$current_rcno.'%')->orderBy('grnnumber', 'DESC')->first();
            $grnnumber=$po_data['grnnumber']??NULL;
            $old_grnnumber=str_replace("G","",$grnnumber);
            $old_grnnumber_data=str_pad($old_grnnumber+1,9,0,STR_PAD_LEFT);
            $new_grnnumber='G'.$old_grnnumber_data;
        }else{
            $str='000001';
            $new_grnnumber=$current_rcno.$str;
        }
        $po_datas=PODetail::where('status','=',0)->get();
        // dd($po_datas);
        return view('grn_inward.create',compact('po_datas','new_grnnumber','current_date'));
    }

    public function grn_rmfetchdata(Request $request){
        $id=$request->id;
        $count = POProductDetail::where('id',$id)->get()->count();
        if ($count>0) {
            $po_product_datas = POProductDetail::find($id);
                $sc_product_id=$po_product_datas->supplier_product_id;
                $rm_datas=RawMaterial::find($sc_product_id);
                $max_qty=$rm_datas->maximum_stock;
                $racks=Rackmaster::where('raw_material_id',$sc_product_id)->get();
                $sc_datas=SupplierProduct::find($sc_product_id);
                $uom_data_id=$sc_datas->uom_id;
                $uom_data=ModeOfUnit::find($uom_data_id);
                $html='';
            foreach ($racks as $key => $rack) {
                $html .= '<option value="'.$rack->id.'">'.$rack->rack_name.'</option>';
            }
            $uom='';
            $uom .= '<option value="'.$uom_data->id.'">'.$uom_data->name.'</option>';
            return response()->json(['max_qty'=>$max_qty,'html'=>$html,'count'=>$count,'uom'=>$uom]);
        }
    }

    public function addGRNItem(Request $request)
    {
        if($request->rm_id)
        {
            $id=$request->rm_id;
            $count = POProductDetail::where('id',$id)->get()->count();
            if ($count>0) {
                $po_product_datas = POProductDetail::find($id);
                $sc_product_id=$po_product_datas->supplier_product_id;
                $rm_datas=RawMaterial::find($sc_product_id);
                $racks=Rackmaster::where('raw_material_id',$sc_product_id)->get();
                $sc_datas=SupplierProduct::find($sc_product_id);
                $uom_data_id=$sc_datas->uom_id;
                $uom_data=ModeOfUnit::find($uom_data_id);
                $html = view('grn_inward.add_items',compact('uom_data','racks'))->render();
                return response()->json(['category'=>$html]);
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGRNInwardRegisterRequest $request)
    {
        //SELECT `id`, `grnnumber_id`, `rack_id`, `heat_no_id`, `inspected_by`, `inspected_date`, `inspected_qty`, `approved_qty`, `onhold_qty`, `rejected_qty`, `status`, `prepared_by`, `updated_by`, `created_at`, `updated_at` FROM `grn_qualities` WHERE 1

        // dd($request);
        DB::beginTransaction();
        try {
            $grn_datas = new GRNInwardRegister;
            $grn_datas->grnnumber = $request->grnnumber;
            $grn_datas->grndate = $request->grndate;
            $grn_datas->po_id = $request->po_id;
            $grn_datas->p_o_product_id = $request->rm_id;
            $grn_datas->invoice_number = $request->invoice_number;
            $grn_datas->invoice_date = $request->invoice_date;
            $grn_datas->dc_number = $request->dc_number;
            $grn_datas->dc_date = $request->dc_date;
            $grn_datas->inward_qty = $request->grand_total;
            $grn_datas->prepared_by = auth()->user()->id;
            $grn_datas->save();

            $grn_id=$grn_datas->id;

            $rack_ids=$request->rack_id;

            foreach ($rack_ids as $key => $rack_id) {
                $grn_heat_nos = new HeatNumber;
                $grn_heat_nos->grnnumber_id =$grn_id;
                $grn_heat_nos->heatnumber =$request->heatnumber[$key];
                $grn_heat_nos->tc_no =$request->tc_no[$key];
                $grn_heat_nos->rack_id =$rack_id;
                $grn_heat_nos->lot_no =$request->lot_no[$key];
                $grn_heat_nos->coil_no =$request->coil_no[$key];
                $grn_heat_nos->coil_inward_qty =$request->coil_inward_qty[$key];
                $grn_heat_nos->prepared_by = auth()->user()->id;
                $grn_heat_nos->save();

                $heat_no_id=$grn_heat_nos->id;

                $grn_qc=new GrnQuality;
                $grn_qc->grnnumber_id =$grn_id;
                $grn_qc->heat_no_id =$heat_no_id;
                $grn_qc->rack_id =$rack_id;
                $grn_qc->inspected_qty =$request->coil_inward_qty[$key];
                $grn_qc->prepared_by = auth()->user()->id;
                $grn_qc->save();
            }
            DB::commit();
            return back()->withSuccess('GRN is Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            //dd($th->getMessage());
            return response()->json(['errors' => $th->getMessage()]);
            // return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGRNInwardRegisterRequest $request, GRNInwardRegister $gRNInwardRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GRNInwardRegister $gRNInwardRegister)
    {
        //
    }
}
