<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $roles = Role::all();
        view()->share('roles',$roles);
    }
    public function index()
    {
        $data = User::orderBy('id','DESC')->get();
        return view('admin.user.index', compact('data'));
    }
    public function create()
    {
        $title = 'Add New User';
        return view('admin.user.create', compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:'.User::class,
            'password' => 'required|max:255|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mode' => 'light',
            'password' => bcrypt($request->password),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        $user->assignRole($request->role);
        return redirect()->route('admin.user.index')->with('success','User created successfully.');
    }
    public function edit($id)
    {
        $title = 'Edit User';
        $user = User::where('id',decrypt($id))->first();
        return view('admin.user.edit',compact('user', 'title'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string']
        ]); 

        $role_id = $this->getRoleIdByName($request->role);
        
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $role_id;
        $user->mode = 'light';
        $user->updated_by = Auth::user()->id;
        $user->save();
        $user->assignRole($request->role);
        return redirect()->route('admin.user.index')->with('success','User updated successfully.');
    }

    public function getRoleIdByName($role)
    {
        $query = Role::where('name', $role)->pluck('id');
        return $query[0];
    }

    public function changeStatus(Request $request)
    {
        $status = $request->input('status');
        $id = $request->input('id');

        if($status == 1){
            $status = 0;
        }else{
            $status = 1;
        }

        DB::beginTransaction();
        try {

            $queryStatus = User::find($id);
            $queryStatus->status = $status;
            $queryStatus->updated_by = Auth::user()->id;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
