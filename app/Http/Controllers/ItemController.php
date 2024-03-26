<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Barcode;
use App\Models\ItemSupplier;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Location;
use DB;
use Auth;

class ItemController extends Controller
{
    public function index()
    {
        $title = 'Item Maintainance';
        $data = Item::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.item.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Add New Item';
        $page = 'add';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        $locations = Location::where('status', 1)->orderBy('name','ASC')->get();

        return view('admin.item.create', compact('title', 'page', 'suppliers', 'departments', 'sub_departments', 'locations'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Item';
        $page = 'edit';
        $data = Item::where('id',decrypt($id))->first();
        return view('admin.item.create',compact('data', 'title', 'page'));
    }

    public function store(Request $request)
    {
        $response = array();

            try{
                DB::beginTransaction();

                $createBarcode = Barcode::create([
                    'product_code' => $request->input('product_code'),
                    'barcode' => $request->input('product_code'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                if($createBarcode){

                    $createItem = Item::create([
                        'barcode_id' => $createBarcode->id,
                        'department_id' => $request->input('department'),
                        'sub_department_id' => $request->input('sub_department'),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);

                    $addSuppliers = ItemSupplier::create([
                        'item_id' => $createItem->id,
                        'supplier_id' => $request->input('supplier'),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                }

                DB::commit(); 

                if($addSuppliers){
                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $createItem->id;
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
                    $response['data'] = '';
                }

                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = $e->getMessage();
                return json_encode($response);
            } 
    }

    public function storeItemDetails(Request $request)
    {
        $id = $request->input('id');
        $response = array();

            try{
                DB::beginTransaction();

                    $updateItemDetails = Item::where('id', $id)->update([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'item_size' => $request->input('item_size'),
                        'margin_type' => $request->input('margin_type'),
                        'updated_by' => Auth::user()->id,
                    ]);

                DB::commit();

                if($updateItemDetails){
                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $id;
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
                    $response['data'] = '';
                }
                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }

    public function updateStockSettings(Request $request)
    {
        $id = $request->input('item_id');
        $auto_order = 1;
        $status = 1;
        $exclude_from_stock = 1;
        $response = array();

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if(!$request->input('auto_order')){
            $auto_order = 0;
        }
   
        if(!$request->input('status')){
            $status = 0;
        }
 
        if(!$request->input('exclude_from_stock')){
            $exclude_from_stock = 0;
        }
      
            try{
                DB::beginTransaction();
                    $imageName = $id.'-'.date("YmdHis").'.'.$request->image->extension();  
                    $upload = $request->image->move(public_path('images'), $imageName);

                    $updateItemDetails = Item::where('id', $id)->update([
                        'image' => $imageName,
                        'min_stock' => $request->input('min_stock'),
                        'location_id' => $request->input('location'),
                        'auto_order' => $auto_order,
                        'status' => $status,
                        'exclude_from_stock' => $exclude_from_stock,
                        'updated_by' => Auth::user()->id,
                    ]);

                DB::commit();

                if($updateItemDetails){
                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $id;
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
                    $response['data'] = '';
                }
                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }

    public function updatePriceDetails(Request $request)
    {
        $id = $request->input('id');
        $response = array();

            try{
                DB::beginTransaction();

                    $updateItemDetails = Item::where('id', $id)->update([
                        'cost_price' => $request->input('cost_price'),
                        'retail_price' => $request->input('retail_price'),
                        'margin' => $request->input('margin'),
                        'updated_by' => Auth::user()->id,
                    ]);

                DB::commit();

                if($updateItemDetails){
                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $id;
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
                    $response['data'] = '';
                }
                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }
}
