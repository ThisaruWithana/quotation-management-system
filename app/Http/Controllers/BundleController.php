<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bundle;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\BundleItem;
use App\Models\Item;
use DB;
use Auth;

class BundleController extends Controller
{
    public function index()
    {
        $data = Bundle::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.bundle.index', compact('data'));
    }

    public function create()
    {
        $title = 'Add New bundle';
        $page = 'add';
        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        return view('admin.bundle.create', compact('title', 'page', 'departments', 'sub_departments', 'suppliers'));
    }

    public function edit($id)
    {
        $title = 'Edit Bundle';
        $page = 'edit';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        $data = Bundle::where('id',decrypt($id))->first();

        $bundleItems = $this->getBundleItems(decrypt($id));
     
        return view('admin.bundle.edit',compact('data', 'title', 'bundleItems', 'page', 'departments', 'sub_departments', 'suppliers'));
    }

    public function store(Request $request)
    {
        $response = array();

        try{
            DB::beginTransaction();
    
            $store = Bundle::updateOrCreate(
                [
                    'id'=>$request->input('bundle_id')
                ],[
                    'name' => $request->input('name'),
                    'remark' => $request->input('remark'),
                    'bundle_cost' => $request->input('bundle_cost'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]
            );

            if($request->input('bundle_id')){
                $id = $request->input('bundle_id');
            }else{
                $id = $store->id;
            }

            DB::commit(); 

            if($store){
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
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function addItems(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');
        $bundle_id = $request->input('bundle_id');

        try{
            DB::beginTransaction();

            $itemDetails = Item::where('id',$id)->first();
            $actual_cost = $itemDetails['cost_price'];
            $retail = $itemDetails['retail_price'];

            if($ischecked === 'true'){
                $is_checked = 1;
   
                $qty = 1;
                $total_cost = $actual_cost * $qty;
                $total_retail = $retail * $qty;

                $getLastInsert = BundleItem::where('bundle_id', $bundle_id)->where('status', 1)->orderBy('id', 'desc')->first();
     
                    if(empty($getLastInsert)){
                        $order = 1;
                    }else{
                        $lastInsertOrder = $getLastInsert['order'];
                        $order = $lastInsertOrder + 1;
                    }

                $store = BundleItem::create([
                    'bundle_id' => $request->input('bundle_id'),
                    'item_id' => $id,
                    'actual_cost' => $actual_cost,
                    'retail' => $retail,
                    'qty' => 1,
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail,
                    'order' => $order,
                    'status' => $is_checked,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

            }else{

                $is_checked = 0;

                $store = BundleItem::where('bundle_id', $bundle_id)
                            ->where('item_id', $id)->where('status', 1)->update([
                                'status' => $is_checked,
                                'updated_by' => Auth::user()->id
                            ]);
            }

            DB::commit(); 
            $total_cost = $this->getTotalCost($bundle_id);
            $total_retail = $this->getTotalRetail($bundle_id);
            $bundle_cost = $this->getBundleCost($bundle_id);

            if($store){

                $queryUpdate = Bundle::where('id', $bundle_id)->where('status', 1)->update([
                                'total_cost' => $total_cost,
                                'total_retail' => $total_retail,
                                'updated_by' => Auth::user()->id
                            ]);
                
                $getBundleItemList = $this->getBundleItems($bundle_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getBundleItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['bundle_cost'] = $bundle_cost;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['bundle_cost'] = $bundle_cost;
            }
              
            return json_encode($response);
        }catch(\Exception $e){
            DB::rollback();
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function getTotalCost($bundle_id)
    {
       return $query = BundleItem::where('bundle_id', $bundle_id)->where('status', 1)->sum('total_cost');
    }

    public function getTotalRetail($bundle_id)
    {
        return $query = BundleItem::where('bundle_id', $bundle_id)->where('status', 1)->sum('total_retail');
    }

    public function getBundleCost($bundle_id)
    {
        return $query = Bundle::where('id', $bundle_id)->where('status', 1)->pluck('bundle_cost');
    }

    public function updateDisplayStatus(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');

            try{
                DB::beginTransaction();

                if($ischecked == 'true'){
                    $display_report = 1;
                }else{
                    $display_report = 0;
                }

                $update = BundleItem::where('id', $id)->update([
                    'display_report' => $display_report,
                    'updated_by' => Auth::user()->id
                ]);

                DB::commit(); 

                if($update){
                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = '';
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

    public function deleteItem(Request $request)
    {
        $response = array();
        $id = $request->input('id');
        $bundle_id = $request->input('bundle_id');

            try{
                DB::beginTransaction();

                $update = BundleItem::where('id', $id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);

                $total_cost = $this->getTotalCost($bundle_id);
                $total_retail = $this->getTotalRetail($bundle_id);
                $bundle_cost = $this->getBundleCost($bundle_id);
                
                $queryUpdate = Bundle::where('id', $bundle_id)->where('status', 1)->update([
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                DB::commit(); 

                if($update){
                   
                    $getBundleItemList = $this->getBundleItems($bundle_id);

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getBundleItemList;
                    $response['total_cost'] = $total_cost;
                    $response['total_retail'] = $total_retail;
                    $response['bundle_cost'] = $bundle_cost;
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

            $queryStatus = Bundle::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function itemUpdate(Request $request)
    {
        $response = array();
        $bundle_item_id = $request->input('bundle_item_id');
        $actual_cost = $request->input('actual_cost');
        $qty = $request->input('qty');
        $bundle_id = $request->input('bundle_id');
        $retail = $request->input('retail');

            try{
                DB::beginTransaction();
                $item_total_cost = $actual_cost * $qty;
                $item_total_retail = $retail * $qty;

                $update = BundleItem::where('id', $bundle_item_id)->update([
                    'actual_cost' => $actual_cost,
                    'qty' => $qty,
                    'total_cost' => $item_total_cost,
                    'total_retail' => $item_total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){

                    $total_cost = $this->getTotalCost($bundle_id);
                    $total_retail = $this->getTotalRetail($bundle_id);
                    $bundle_cost = $this->getBundleCost($bundle_id);
          
                    $queryUpdate = Bundle::where('id', $bundle_id)->where('status', 1)->update([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail,
                        'updated_by' => Auth::user()->id
                    ]);
 
                    
                    if($queryUpdate){
                        DB::commit(); 
                   
                        $getBundleItemList = $this->getBundleItems($bundle_id);

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getBundleItemList;
                        $response['total_cost'] = $total_cost;
                        $response['total_retail'] = $total_retail;
                        $response['bundle_cost'] = $bundle_cost;
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                        $response['msg'] = 'Something went wrong !';
                        $response['data'] = '';
                    }
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

    public function getBundleItems($bundleId)
    {
        $bundleItemList = BundleItem::with('item', 'item.suppliers.suppliername')
        ->where('bundle_id', $bundleId)->where('status', 1)
        ->orderBy('order','ASC')->get();

        $bundleItems = array();

        foreach($bundleItemList as $value){
            $supplierList = array();
                    
                foreach($value['item']['suppliers'] as $supplier){
                    $supplier = $supplier['suppliername']['name'];
                    array_push($supplierList, $supplier);
                }
                    
                $data2 = ([
                    'id' => $value['id'],
                    'item_id' => $value['item']['id'],
                    'name' => $value['item']['name'],
                    'actual_cost' => $value['actual_cost'],
                    'retail' => $value['retail'],
                    'qty' => $value['qty'],
                    'total_cost' => $value['total_cost'],
                    'total_retail' => $value['total_retail'],
                    'display_report' => $value['display_report'],
                    'bundle_id' => $value['bundle_id'],
                    'supplier' => implode(" ",$supplierList)
                    ]);

            array_push($bundleItems, $data2);
        }
     return $bundleItems;
    }

    public function getDetails(Request $request)
    {
        $data = Bundle::where('id',$request->input('id'))->first();
        return json_encode($data);
    }
}
