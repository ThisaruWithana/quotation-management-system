<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use DB;
use Auth;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $pageSize;

        if (!isset($request->pagesize)) {
            $new = 10;
        }else{
            $new = $request->pagesize;
        }

        $pageSize = $new;
        $title = 'Customers';
        $keyword = $request->input('keyword');

        $data = Customer::query()->with('created_user')->orderBy('id','DESC');

        
        if($request->query('form_action') === 'search'){

            if(!is_null($keyword)) {
                $data->where(function ($qry) use ($keyword) {
                    $qry->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('code', 'like', '%' . $keyword . '%')
                        ->orWhere('contact_person', 'like', '%' . $keyword . '%')
                        ->orWhere('postal_code', 'like', '%' . $keyword . '%');
                });
            }
        }
        $listData = $data->paginate($pageSize);  

        return view('admin.customer.index', compact('listData', 'title', 'pageSize'));
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

            // Check validation
            if($request->input('id')){
                $request->validate([
                    'name' => 'required', 'string', 'max:255',
                    'contact_person' => 'required',
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'address' => 'required|max:255',
                    'tel' => 'required|max:11',
                ]);
            }else{
                $request->validate([
                    'name' => 'required', 'string', 'max:255',
                    'contact_person' => 'required',
                    'email' => 'required', 'string', 'email', 'max:255',
                    'address' => 'required|max:255',
                    'tel' => 'required|max:11',
                ]);
            }

            try{
                DB::beginTransaction();

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
                    $customer_id = $id;
                    $code = $this->generateCustomerCode($id);
                    $msg = 'Customer updated successfully.';

                }else{
                    $customer_id = $query->id;
                    $code = $this->generateCustomerCode($query->id);
                    $msg = 'Customer created successfully.';
                }

                $update = Customer::where('id', $customer_id)->update([
                    'code' => $code,
                    'updated_by' => Auth::user()->id
                ]);

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

    public function generateCustomerCode($customerId)
    {
       $customer = Customer::where('id',$customerId)->first();

       if($customer){

            $customer_id = $customer->id;
            $customer_type = $customer->type;
            $code;
            $type;

            $length = strlen((string)$customer_id);

            if($customer_type === 'Prospective'){
                $type = 'P';
            }else if($customer_type === 'Accepted'){
                $type = 'A';
            }else{
                $type = 'I';
            }

            if($length == 1){
                $code =  $type.'000'.$customer_id;
            }else if($length == 2){
                $code =  $type.'00'.$customer_id;
            }else if($length == 3){
                $code =  $type.'0'.$customer_id;
            }else{
                $code =  $type.$customer_id;
            }

            return $code;
       }
    }

    public function getDetails(Request $request)
    {
        $data = Customer::where('id',$request->input('id'))->first();
        return json_encode($data);
    }

    public function getCustomerList()
    {
        $customers = Customer::where('status', 1)->orderBy('name','ASC')->get();
        return json_encode($customers);
    }
}
