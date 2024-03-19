<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use DB;
use Auth;


class CustomerController extends Controller
{

    public function index()
    {
        $title = 'Customers';
        $data = Customer::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.customer.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Add New Customer';
        $page = 'add';
        return view('admin.customer.create', compact('title', 'page'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Customer';
        $page = 'edit';
        $data = Customer::where('id',decrypt($id))->first();
        return view('admin.customer.create',compact('data', 'title', 'page'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
            try{
                DB::beginTransaction();

                // Check validation
                if($request->input('id')){
                    $request->validate([
                        'name' => 'required', 'string', 'max:255',
                        'contact_person' => 'required',
                        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customer')->ignore($id)],
                        'address' => 'required|max:255',
                        'tel' => 'required|max:15',
                        'symbol_group' => 'required',
                    ]);
                }else{
                    $request->validate([
                        'name' => 'required', 'string', 'max:255',
                        'contact_person' => 'required',
                        'email' => 'required', 'string', 'email', 'max:255', 'unique:'.Customer::class,
                        'address' => 'required|max:255',
                        'tel' => 'required|max:15',
                        'symbol_group' => 'required',
                    ]);
                }

                // Add or update customer details
                $query = Customer::updateOrCreate(
                    [
                        'id'=>$id
                    ],[
                        'name' => $request->input('name'),
                        'contact_person' => $request->input('contact_person'),
                        'symbol_group' => $request->input('symbol_group'),
                        'type' => $request->input('ctype'),
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
                    $msg = 'Customer updated successfully.';
                }else{
                    $msg = 'Customer created successfully.';
                }
                return redirect()->route('admin.customer.index')->with('success',$msg);

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

            $queryStatus = Customer::find($id);
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
