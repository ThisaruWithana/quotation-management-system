<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use DB;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::orderBy('id','DESC')->where('name', '!=', 'superadmin')->get();
        return view('admin.role.index', compact('data'));
    }

    public function create()
    {
        $title = 'Add New Role';
        $permissions = Permission::where('status',1)->get();
        return view('admin.role.create', compact('permissions', 'title'));
    }

    public function store(Request $request)
    {
            try{
                DB::beginTransaction();
            
                if($request->id){
                    $request->validate([
                        'name' => 'required|max:25|unique:roles,name,'.$request->id,
                        'permission' => 'required',
                    ]);
                }else{
                    $request->validate([
                        'name' => 'required|unique:roles|max:255',
                        'permission' => 'required',
                    ]);
                }
                $role = Role::updateOrCreate(
                    [
                        'id'=>$request->id
                    ],[
                        'name'=>$request->name,
                    ]
                );
        
                 $role->syncPermissions([$request->input('permission')]);
        
                DB::commit();

                if($request->id){
                    $msg = 'Role updated successfully.';
                }else{
                    $msg = 'Role created successfully.';
                }
        
                return redirect()->route('admin.role.index')->with('success',$msg);

            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }

    public function edit($id)
    {
        $title = 'Edit Role';
        $data = Role::with('permissions')->where('id',decrypt($id))->first();
        $selectedPermissions = RolePermission::where('role_id',decrypt($id))->pluck('permission_id')->toArray();
        $permissions = Permission::where('status',1)->get();

        return view('admin.role.edit',compact('data', 'permissions', 'selectedPermissions', 'title'));
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

            $queryStatus = Role::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
