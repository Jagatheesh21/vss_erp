<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use DB;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use App\Notifications\NewNotification;
use App\Jobs\SendNotificationJob;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        dispatch(new SendNotificationJob($user));
        if ($request->ajax()) {
            $data = Department::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($data) {
                        // $status = '<button class="btn btn-sm btn-success">Active</button>';
                        // return $status;
                        return $data->status=1?'Active':'Inactive';
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm text-white editDepartment">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm text-white deleteDepartment">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $department = new Department;
            $department->name = $request->name;
            $department->prepared_by = auth()->user()->id;
            $department->save();
            DB::commit();
            return back()->withSuccess('Department Added Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // dd($department);
        return view('department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        DB::beginTransaction();
        try {
            $department->name = $request->name;
            $department->status = $request->status;
            $department->updated_by = auth()->user()->id;
            $department->save();
            DB::commit();
            return back()->withSuccess('Department Updated Successfully!');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
    public function getDepartments(Request $request)
    {        
        $query = Department::whereNotNull('id');
        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $start = $request->input('start') + 1;
        $totalDataRecord = $query->count();
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'];
        $order_val = $columnNameArray[$columnIndex]['data'];
        $dir_val = $orderArray[0]['dir'];
        $search_text = $request->input('search.value');

        $filteredUserQuery = $query->select('id','name','status');
        
        if (!empty($search_text)) {
            $filteredUserQuery = $filteredUserQuery->where(function ($query) use ($search_text) {
                $query->where('name', 'LIKE', "%{$search_text}%");
                    // ->orWhere('user.name', 'LIKE', "%{$search_text}%");
            });
        }
        $totalFilteredRecord = $filteredUserQuery->count();
        $post_data = $filteredUserQuery->select('id','name','status');
        $post_data = $post_data->limit($limit_val)
            ->offset($start_val)
            // ->orderBy($order_val, $dir_val)
            ->get();
        if(!empty($post_data))
        {
            $count = 1;
            foreach ($post_data  as $index =>  $row) {
                $serialNumber = $start + $index;
                $active_value = '<div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" id="' . $row->id . '" onclick="editVehicle(' . $row->id . ')">Edit</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="' . $row->id . '" onclick="changeSim(' . $row->id . ')">Change Sim</a>
                        </div>
                        </div>';
                $array_data[] = array(
                    'id' => $serialNumber ?? "",
                    'name' => $row->name ?? "",
                    'status'=> $row->status??"",
                    'action' => $active_value,
                );

            }
            if(!empty($array_data))
            {
                $draw_val = $request->input('draw');
                $get_json_data = array(
                    "draw"            => intval($draw_val),
                    "recordsTotal"    => intval($totalDataRecord),
                    "recordsFiltered" => intval($totalFilteredRecord),
                    "data"            => $array_data
                );
                echo json_encode($get_json_data);
            }
       }

    }
}
