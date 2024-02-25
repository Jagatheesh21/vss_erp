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
use App\Models\ProductProcessMaster;
use App\Models\HeatNumber;
use App\Models\TransDataD11;
use App\Models\TransDataD12;
use App\Models\BomMaster;
use App\Models\ChildProductMaster;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StagewiseIssueController extends Controller
{
    //Semi Finished Issue Entry Start
    public function sfIssueList(){
        $d12Datas=DB::table('trans_data_d12_s as a')
        ->join('item_procesmasters AS b', 'a.process_id', '=', 'b.id')
        ->join('child_product_masters AS c', 'a.part_id', '=', 'c.id')
        ->join('users AS d', 'a.prepared_by', '=', 'd.id')
        ->select('b.operation','b.id as process_id','a.open_date','a.rc_no','a.previous_rc_no','a.issue_qty','c.child_part_no as part_no','a.prepared_by','a.created_at','d.name as user_name')
        ->whereIn('process_id', [3,4,5])
        ->whereRaw('a.rc_no!=a.previous_rc_no')
        ->orderBy('a.id', 'DESC')
        ->get();
    //    dd($d12Datas);
       return view('stagewise-issue.sf_view',compact('d12Datas'));
    }
    public function sfIssueEntry(Request $request){

    }
}
