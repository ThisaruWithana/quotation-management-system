<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;

class PermissionController extends Controller
{
    public function index()
    {
        $data = Permission::orderBy('id','DESC')->get();
        return view('admin.permission.index',compact('data'));
    }

    public function create()
    {
        $title = 'Add New Permission';
        return view('admin.permission.create',compact('title'));
    }

    public function store(Request $request)
    {
        if($request->input('id')){
            $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($request->input('id'))]
            ]);
        }else{
            $request->validate([
                'name' => 'required', 'string', 'max:255', 'unique:'.Permission::class
            ]);
        }

        Permission::updateOrCreate(
            [
                'id'=>$request->id
            ],[
                'name'=>$request->name,
            ]
        );
        if($request->id){
            $msg = 'Permission updated successfully.';
        }else{
            $msg = 'Permission created successfully.';
        }
        return redirect()->route('admin.permission.index')->with('success',$msg);
    }

    public function edit($id)
    {
        $title = 'Edit Permission';
        $data = Permission::where('id',decrypt($id))->first();
        return view('admin.permission.edit',compact('data', 'title'));
    }

    public function destroy($id)
    {
        Permission::where('id',decrypt($id))->delete();
        return redirect()->route('admin.permission.index')->with('error','Permission deleted successfully.');
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

            $queryStatus = Permission::find($id);
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
