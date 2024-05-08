<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::OrderBy('id','DESC')->get();
        return view('permissions.index',compact('permissions'));
    }
    public function create()
    {
        return view('permissions.create');
    }
    public function store(StorePermissionRequest $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->guard_name = "web";
        $permission->save();
        return redirect()->route('permissions.index')
        ->withSuccess('New Permission is added successfully.');

    }
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit',compact('permission'));
    }
    public function show($id)
    {
        dd($id);
    }
    public function update(Request $request,Permission $permission)
    {
        $permission->name = $request->name;
        $permission->save();
        return redirect(route('permissions.index'));
    }
    public function destroy(Request $request)
    {

    }
}
