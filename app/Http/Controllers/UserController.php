<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::latest('id')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        return redirect()->back()
                ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
                ->withSuccess('User is deleted successfully.');
    }

    public function userIndex(){
        $userDatas=DB::table('users as a')
        ->join('model_has_roles AS b', 'a.id', '=', 'b.model_id')
        ->join('roles AS c', 'c.id', '=', 'b.role_id')
        ->select('c.name as role','b.role_id','a.id as user_id','a.name','a.email','a.username','a.password')
        ->orderBy('a.id', 'DESC')
        ->get();
        // dd($userDatas);
        return view('users.index',compact('userDatas'));
    }

    public function userCreate(){

        $roles=Role::all();
        $userDatas=User::orderBy('id','DESC')->first();
        $old_username=$userDatas->username;
        $new_username=$old_username+1;
        return view('users.create',compact('roles','new_username'));
    }

    public function userStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('usercreate')
                        ->withErrors($validator)
                        ->withInput();
        }else {
            // dd($request->all());

            $input = $request->all();
            $input['password'] = Hash::make($request->password);

            $user = User::create($input);
            $user->assignRole($request->roles);

            return redirect()->route('userindex')
                    ->withSuccess('New user is added successfully.');
        }


    }

    public function userEdit($id){
        dd($id);
    }
}
