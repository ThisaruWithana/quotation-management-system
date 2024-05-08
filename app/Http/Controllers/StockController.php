<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Po;
use App\Models\PoItems;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Bundle;
use App\Models\SubItem;
use DB;

class StockController extends Controller
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
        $supplier_id = $request->input('supplier');

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $data = Po::query()->with('supplier')->whereIn('status', [1,0])->orderBy('id','DESC');

        if($request->query('form_action') === 'search'){

            if(!is_null($supplier_id)) {
                $data->where('supplier_id',  $supplier_id);
            }
        }

        $listData = $data->paginate($pageSize);  

        return view('admin.po.index',compact('listData', 'pageSize', 'suppliers'));
    }

    public function create()
    {
        $title = 'Add New Purchase Order';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        return view('admin.po.create', compact(
            'title', 'suppliers', 'departments', 'sub_departments'));
    }

    public function store(Request $request)
    {
        $response = array();

         try{
             DB::beginTransaction();

             $store = Po::updateOrCreate(
                 [
                     'id'=>$request->input('po_id')
                 ],[
                     'supplier_id' => $request->input('supplier'),
                     'reference' => $request->input('remark'),
                     'type' => $request->input('type'),
                     'order_date' => $request->input('order_date'),
                     'expected_date' => $request->input('expected_date'),
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id
                 ]
             );
 
             DB::commit(); 
 
             if($store){
                 $response['code'] = 1;
                 $response['msg'] = "Success";
                 $response['data'] = $store->id;
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
             $response['msg'] =  $e->getMessage();
             return json_encode($response);
        } 
    }

    public function edit($id)
    {
        $title = 'Edit PO';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        
        $data = Po::where('id',decrypt($id))->first();

        $itemList = $this->getPoItems(decrypt($id));
     
        return view('admin.po.edit',compact('data', 'title', 'itemList',
                'departments', 'sub_departments', 'suppliers'));
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

            $queryStatus = Po::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getPoItems($poId)
    {
        $itemList = PoItems::with('item', 'item.suppliers.suppliername', 'item.department', 'item.subdepartment')
        ->where('po_id', $poId)->where('status', 1)->get();

        $itemsArr = array();

        foreach($itemList as $value){
            $supplierList = array();

                foreach($value['item']['suppliers'] as $supplier){
                    $supplier = $supplier['suppliername']['name'];
                    array_push($supplierList, $supplier);
                }

                $name = $value['item']['name'];
                $item_id = $value['item']['id'];
                $actual_cost = $value['item']['cost_price'];
       
                    
                $data2 = ([
                    'id' => $value['id'],
                    'item_id' => $item_id,
                    'po_id' => $value['po_id'],
                    'name' => $name,
                    'item_cost' => $value['item_cost'],
                    'retail' => $value['retail'],
                    'qty' => $value['qty'],
                    'total_cost' => $value['total_cost'],
                    'total_retail' => $value['total_retail'],
                    'supplier' => implode(" ",$supplierList),
                    'department' => $value['item']['department']['name'],
                    'sub_department' => $value['item']['subdepartment']['name']
                    ]);

            array_push($itemsArr, $data2);
        }
     return $itemsArr;
    }

    public function getPoTotalCost($poId)
    {
       return $query = PoItems::where('po_id', $poId)->where('status', 1)->sum('total_cost');
    }

    public function addItems(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');
        $po_id = $request->input('po_id');

        try{
            DB::beginTransaction();

            $itemDetails = Item::where('id',$id)->first();
            $actual_cost = $itemDetails['cost_price'];

            if($ischecked === 'true'){
                $is_checked = 1;
   
                $qty = 1;
                $total_cost = $actual_cost * $qty;
         
                $store = PoItems::create([
                    'po_id' => $po_id,
                    'item_id' => $id,
                    'item_cost' => $actual_cost,
                    'qty' => 1,
                    'total_cost' => $total_cost,
                    'status' => $is_checked,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                
                if($request->input('type') === 'main'){

                    $checkSubItems = SubItem::where('parent_id',$id)->where('status', 1)->get();

                    if(count($checkSubItems) > 0){
    
                        foreach($checkSubItems as $value){
                            $is_mandatory = $value['is_mandatory'];
    
                            if($is_mandatory == 1){
                                $lastInsert = PoItems::where('po_id', $po_id)->where('status', 1)->orderBy('id', 'desc')->first();
         
                                if(empty($lastInsert)){
                                    $subItemOrder = 1;
                                }else{
                                    $lastInsert = $lastInsert['order'];
                                    $subItemOrder = $lastInsert + 1;
                                }
                    
                                $store = PoItems::create([
                                    'po_id' => $po_id,
                                    'item_id' => $value['subitem']['id'],
                                    'item_cost' => $value['subitem']['cost_price'],
                                    'qty' => 1,
                                    'total_cost' => $value['subitem']['cost_price'],
                                    'status' => 1,
                                    'created_by' => Auth::user()->id,
                                    'updated_by' => Auth::user()->id,
                                ]);
                            }
                        }
                    }
    
                }
            }else{

                $is_checked = 0;

                $store = PoItems::where('po_id', $po_id)
                            ->where('item_id', $id)->where('status', 1)->update([
                                'status' => $is_checked,
                                'updated_by' => Auth::user()->id
                            ]);
            }

            DB::commit(); 
            $total_cost = $this->getPoTotalCost($po_id);

            if($store){

                $request->request->add([
                    'total_cost' => $total_cost
                ]);

                $updatePriceInfo = $this->updatePriceInfo($request);
                $getItemList = $this->getPoItems($po_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getItemList;
                $response['total_cost'] = $total_cost;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
            }
              
            return json_encode($response);
        }catch(\Exception $e){
            DB::rollback();
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function updatePriceInfo(Request $request)
    {
        $response = array();
        $po_id = $request->input('po_id');

            try{
                DB::beginTransaction();

                $update = Po::where('id', $po_id)->update([
                    'total_cost' => floatval($request->input('total_cost')),
                    'updated_by' => Auth::user()->id
                ]);

                if($update){
                    DB::commit(); 

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                  
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
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
        $po_id = $request->input('po_id');

            try{
                DB::beginTransaction();

                $update = PoItems::where('id', $id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);

                $total_cost = $this->getPoTotalCost($po_id);

                DB::commit(); 

                if($update){

                    $request->request->add([
                        'total_cost' => $total_cost,
                    ]);
    
                    $updatePriceInfo = $this->updatePriceInfo($request);
                    $getItemList = $this->getPoItems($po_id);

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getItemList;
                    $response['total_cost'] = $total_cost;
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

    public function itemUpdate(Request $request)
    {
        $response = array();
        $item_id = $request->input('item_id');
        $qty = $request->input('qty');
        $po_id = $request->input('po_id');
        $actual_cost = $request->input('actual_cost');

            try{
                DB::beginTransaction();
                $item_total_cost = $actual_cost * $qty;

                $update = PoItems::where('id', $item_id)->update([
                    'item_cost' => $actual_cost,
                    'qty' => $qty,
                    'total_cost' => $item_total_cost,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){

                    $total_cost = $this->getPoTotalCost($po_id);
                    
                    $request->request->add([
                        'total_cost' => $total_cost
                    ]);

                    $updatePriceInfo = $this->updatePriceInfo($request);
                    $getItemList = $this->getPoItems($po_id);
                    
                    if($updatePriceInfo){
                        DB::commit(); 

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getItemList;
                        $response['total_cost'] = $total_cost;
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

    public function sendOrder(Request $request)
    {
        $response = array();
        $po_id = $request->input('po_id');

            try{
                DB::beginTransaction();

                $update = Po::where('id', $po_id)->update([
                    'status' =>2,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){
                    DB::commit();
                    $response['code'] = 1;
                    $response['msg'] = "Success";
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

    public function purchaseDelivery(Request $request)
    {
        $pageSize;

        if (!isset($request->pagesize)) {
            $new = 10;
        }else{
            $new = $request->pagesize;
        }

        $pageSize = $new;
        $supplier_id = $request->input('supplier');

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $data = Po::query()->with('supplier')->whereIn('status', [2])->orderBy('id','DESC');

        if($request->query('form_action') === 'search'){

            if(!is_null($supplier_id)) {
                $data->where('supplier_id',  $supplier_id);
            }
        }

        $listData = $data->paginate($pageSize);  

        return view('admin.po.delivery',compact('listData', 'pageSize', 'suppliers'));
    }
}
