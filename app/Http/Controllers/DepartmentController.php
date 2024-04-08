<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\VAT;
use DB;
use Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $title = 'Departments';
        $data = Department::with('created_user', 'vat')->orderBy('id','DESC')->get();
        $subDepartments = SubDepartment::with('created_user', 'departments')->orderBy('id','DESC')->get();
        return view('admin.department.index', compact('data', 'title', 'subDepartments'));
    }

    public function create()
    {
        $title = 'Add New Department';
        $page = 'add';
        $sales_vat = VAT::where('status',1)->get();
        return view('admin.department.create', compact('title', 'page', 'sales_vat'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Department';
        $page = 'edit';
        $data = Department::where('id',decrypt($id))->first();
        $sales_vat = VAT::where('status',1)->get();
        return view('admin.department.create',compact('data', 'title', 'page', 'sales_vat'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        // Check validation
        if($request->input('id')){
            $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('department')->ignore($id)],
                'sales_vat' => 'required'
            ]);
        }else{
            $request->validate([
                'name' => 'required', 'string', 'max:255', 'unique:'.Department::class,
                'sales_vat' => 'required'
            ]);
        }

            try{
                DB::beginTransaction();

                // Add or update department details
                $query = Department::updateOrCreate(
                    [
                        'id'=>$id
                    ],[
                        'name' => $request->input('name'),
                        'code' => $request->input('code'),
                        'vat_id' => $request->input('sales_vat'),
                        'created_by' =>  Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]
                );

                DB::commit();

                if($id){
                    $msg = 'Department updated successfully.';
                }else{
                    $msg = 'Department created successfully.';
                }
                return redirect()->route('admin.department.index')->with('success',$msg);

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

            $queryStatus = Department::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function listSubDepartment()
    {
        $title = 'Sub Departments';
        $data = SubDepartment::with('created_user', 'departments')->orderBy('id','DESC')->get();

        return view('admin.department.sub-department.index', compact('data', 'title'));
    }

    public function createSubDepartment()
    {
        $title = 'Add New Sub Department';
        $page = 'add';
        $departments = Department::where('status',1)->get();
        return view('admin.department.sub-department.create', compact('title', 'page', 'departments'));
    }
    
    public function editSubDepartment($id)
    {
        $title = 'Edit Sub Department';
        $page = 'edit';
        $data = SubDepartment::with('departments')->where('id',decrypt($id))->first();
        $departments = Department::where('status',1)->get();
        
        return view('admin.department.sub-department.create', compact('title', 'page', 'departments', 'data'));
    }

    public function storeSubDepartment(Request $request)
    {
        $id = $request->input('id');

        // Check validation
        if($request->input('id')){
            $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('sub_department')->ignore($id)]
            ]);
        }else{
            $request->validate([
                'name' => 'required', 'string', 'max:255', 'unique:'.SubDepartment::class
            ]);
        }

            try{
                DB::beginTransaction();

                // Add or update department details
                $query = SubDepartment::updateOrCreate(
                    [
                        'id'=>$id
                    ],[
                        'name' => $request->input('name'),
                        'code' => $request->input('code'),
                        'department_id' => $request->input('department'),
                        'created_by' =>  Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]
                );

                DB::commit();

                if($id){
                    $msg = 'Sub Department updated successfully.';
                }else{
                    $msg = 'Sub Department created successfully.';
                }
                return redirect()->route('admin.department.sub.index')->with('success',$msg);

            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }

    public function changeStatusSubDepartments(Request $request)
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

            $queryStatus = SubDepartment::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getSubDepartmentByDept(Request $request)
    {
        $department = $request->input('department');
        $data = SubDepartment::where('department_id', $department)->where('status', 1)->orderBy('name','ASC')->get();
        return json_encode($data);
    }

    public function getVatValue(Request $request)
    {
        $department = $request->input('department');
        $data = Department::with('vat')->where('id', $department)->first();
 
        $response = array();
        $response['vat'] = $data['vat']['value'];

        return json_encode($response);
    }

}
