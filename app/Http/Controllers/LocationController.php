<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use DB;

class LocationController extends Controller
{
    public function index()
    {
        $data = Location::orderBy('id','DESC')->where('status', 1)->get();
        return view('admin.location.index', compact('data'));
    }

    public function create()
    {
        $title = 'Create Product Location';
        return view('admin.location.create', compact('title'));
    }

    public function store(Request $request)
    {
            try{
                DB::beginTransaction();
            
                // if($request->id){
                //     $request->validate([
                //         'name' => 'required',
                //     ]);
                // }else{
                //     $request->validate([
                //         'name' => 'required',
                //     ]);
                // }

                $request->validate([
                    'name' => 'required',
                ]);

                $query = Location::updateOrCreate(
                    [
                        'id'=>$request->id
                    ],[
                        'name'=>$request->name,
                    ]
                );
        
                DB::commit();

                if($request->id){
                    $msg = 'Location updated successfully.';
                }else{
                    $msg = 'Location created successfully.';
                }
        
                return redirect()->route('admin.location.index')->with('success',$msg);

            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }

    public function edit($id)
    {
        $title = 'Edit Product Location';
        $data = Location::where('id',decrypt($id))->first();
        return view('admin.location.create',compact('data', 'title'));
    }

    public function changeStatus(Request $request)
    {
        // Role::where('id',decrypt($id))->delete();
        // return redirect()->route('admin.role.index')->with('error','Role deleted successfully.');

        $status = $request->input('status');
        $id = $request->input('id');

        if($status = 1){
            $status = 0;
        }else{
            $status = 1;
        }

        DB::beginTransaction();
        try {

            $locationStatus = Location::find($id);
            $locationStatus->status = $status;
            $locationStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
