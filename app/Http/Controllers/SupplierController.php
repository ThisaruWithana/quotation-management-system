<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Supplier;
use DB;
use Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $title = 'Suppliers';
        $data = Supplier::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.supplier.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Add New Supplier';
        $page = 'add';
        return view('admin.supplier.create', compact('title', 'page'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Supplier';
        $page = 'edit';
        $data = Supplier::where('id',decrypt($id))->first();
        return view('admin.supplier.create',compact('data', 'title', 'page'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        // Check validation
        if($request->input('id')){
            $request->validate([
                'name' => 'required', 'string', 'max:255',
                'contact_person' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('supplier')->ignore($id)],
                'address' => 'required|max:255',
                // 'tel' => 'required|phone:US,UK'
            ]);
        }else{
 
            $request->validate([
                'name' => 'required', 'string', 'max:255',
                'contact_person' => 'required',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:'.Supplier::class,
                'address' => 'required|max:255',
                // 'tel' => 'required|phone:US,UK'
            ]);
        }
        
            try{
                DB::beginTransaction();

                // Add or update supplier details
                $query = Supplier::updateOrCreate(
                    [
                        'id'=>$id
                    ],[
                        'name' => $request->input('name'),
                        'contact_person' => $request->input('contact_person'),
                        'address' => $request->input('address'),
                        'postal_code' => $request->input('postal_code'),
                        'tel' => $request->input('tel'),
                        'mobile' => $request->input('mobile'),
                        'email' => $request->input('email'),
                        'website' => $request->input('website'),
                        'created_by' =>  Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]
                );

                DB::commit();

                if($id){
                    $msg = 'Supplier updated successfully.';
                }else{
                    $msg = 'Supplier created successfully.';
                }
                return redirect()->route('admin.supplier.index')->with('success',$msg);

            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
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

            $queryStatus = Supplier::find($id);
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
