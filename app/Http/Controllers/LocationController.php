<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Validation\Rule;
use DB;
use Auth;


class LocationController extends Controller
{
    public function index()
    {
        $data = Location::with('created_user')->orderBy('id','DESC')->get();
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

                // Check validation
                if($request->input('id')){
                    $request->validate([
                        'name' => ['required', 'string', 'max:255', Rule::unique('locations')->ignore($request->input('id'))]
                    ]);
                }else{
                    $request->validate([
                        'name' => 'required', 'string', 'max:255', 'unique:'.Location::class
                    ]);
                }

                 $query = Location::updateOrCreate(
                    [
                        'id'=>$request->input('id')
                    ],[
                        'name'=>$request->input('name'),
                        'created_by' =>  Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]
                );
     
                DB::commit();

                if($request->input('id')){
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
        $status = $request->input('status');
        $id = $request->input('id');

        if($status == 1){
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
