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
use App\Models\Deliveries;
use App\Models\DeliveryItems;
use App\Models\PriceChangeLog;
use App\Imports\PoImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\VAT;
use App\Models\ItemStock;
use App\Models\ItemSupplier;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentItems;
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
        $type = $request->input('type');

         try{
             DB::beginTransaction();

             $store = Po::updateOrCreate(
                 [
                     'id'=>$request->input('po_id')
                 ],[
                     'supplier_id' => $request->input('supplier'),
                     'reference' => $request->input('remark'),
                     'type' => $type,
                     'order_date' => $request->input('order_date'),
                     'expected_date' => $request->input('expected_date'),
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id
                 ]
             );

            $po_id = $store->id;
 
             if($store){
                    $request->request->add([
                            'po_id' => $po_id
                        ]);

                    if($type === 'Automatic'){
                        $query = $this->createAutoOrder($request);

                        if($query){
                            DB::commit(); 
                            $response['code'] = 1;
                            $response['msg'] = "Success";
                            $response['data'] = $po_id;
                        }else{
                            DB::rollback();
                            $response['code'] = 0;
                            $response['msg'] = 'Something went wrong !';
                            $response['data'] = '';
                        }

                    }else if($type === 'Import'){
                        $query = $this->importPo($request);

                        if($query){
                            DB::commit(); 
                            $response['code'] = 1;
                            $response['msg'] = "Success";
                        }else{
                            DB::rollback();
                            $response['code'] = 0;
                            $response['msg'] = 'Something went wrong !';
                        }
                    }else{
                        DB::commit(); 
                        $response['code'] = 1;
                        $response['msg'] = "Success";
                    }
                    
                    $total_cost = $this->getPoTotalCost($po_id);
                    $request->request->add([
                        'total_cost' => $total_cost
                    ]);
    
                    $updatePriceInfo = $this->updatePriceInfo($request);
                    $getItemList = $this->getPoItems($po_id);
                    
                    $response['data'] = $getItemList;
                    $response['po_id'] = $po_id;
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
             $response['msg'] =  $e->getMessage();
             return json_encode($response);
        } 
    }

    public function update(Request $request)
    {
        $response = array();

         try{
             DB::beginTransaction();
             
             $update = Po::where('id', $request->input('po_id'))->update([
                'order_date' => $request->input('order_date'),
                'expected_date' => $request->input('expected_date'),
                'supplier_id' => $request->input('supplier'),
                'reference' => $request->input('remark'),
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit(); 
            
            return redirect()->route('admin.po')->with('success','Updated successfully!');
         }catch(\Exception $e){
             DB::rollback();
             return redirect()->route('admin.po')->with('error','Something went wrong!');
        } 
    }

    public function edit($id)
    {
        $title = 'Edit Purchase Order';

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
        $query = PoItems::where('po_id', $poId)->where('status', 1)->sum('total_cost');
        return $query;
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

                    if(!isset($po_id)){
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
                $response['code'] = 66;
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

    public function createAutoOrder(Request $request)
    {
        $supplier_id = $request->input('supplier');
        $po_id = $request->input('po_id');
        $response = array();

         try{
             DB::beginTransaction();

             $itemsList = ItemSupplier::where('supplier_id', $supplier_id)->where('status', 1)->get();

             foreach($itemsList as $value){

                $item_id = $value['item_id'];

                $checkItemInfo = Item::where('id', $item_id)->where('status', 1)->first();

                if($checkItemInfo){
                    $auto_order = $checkItemInfo['auto_order'];

                    if($auto_order === 1){
                        $min_stock = $checkItemInfo['min_stock'];
                        $current_stock = app('App\Http\Controllers\ItemController')->getCurrentStockCount($item_id);

                        if($current_stock < $min_stock){
                            // Create auto order PO
                            $request->request->add([
                                'ischecked' => 'true',
                                'id' => $item_id,
                            ]);

                             $addItem = $this->addItems($request);
                        }

                    }
                }
             }
             DB::commit(); 
             $response['code'] = 1;
             $response['msg'] = "Success";
             $response['data'] = $po_id;
               
             return json_encode($response);
         }catch(\Exception $e){
             DB::rollback();
             $response['code'] = 0;
             $response['msg'] =  $e->getMessage();
             return json_encode($response);
        } 
    }

    public function importPo(Request $request)
    {
       return Excel::import(new PoImport,request()->file('file'));
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

                     $store = $this->createDelivery($po_id);

                    if($store){
                        DB::commit();
                        $response['code'] = 1;
                        $response['msg'] = "Success";
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                        $response['msg'] = 'Something went wrong !';
                    }
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                    $response['msg'] = 'Something went wrong !';
                }
                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                return json_encode($response);
            } 
    }

    public function createDelivery($po_id)
    {
         try{
             DB::beginTransaction();

            $po = Po::where('id',$po_id)->first();

            $store = Deliveries::create([
                'po_id' => $po_id,
                'supplier_id' => $po['supplier_id'],
                'reference' => $po['reference'],
                'total_cost' => $po['total_cost'],
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
 
             if($store){

                $poItems = PoItems::where('po_id',$po_id)->where('status', 1)->get();

                foreach($poItems as $value){
                    $retail_price = $this->getItemRetailPrice($value['item_id']);
                    $total_retail = $retail_price * $value['qty'];

                    $delivery_items = DeliveryItems::create([
                        'delivery_id' => $store->id,
                        'item_id' => $value['item_id'],
                        'item_cost' => $value['item_cost'],
                        'item_retail' => $retail_price,
                        'qty' => $value['qty'],
                        'total_cost' => $value['total_cost'],
                        'total_retail' => $total_retail,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                }

                $update = Deliveries::where('id', $store->id)->update([
                    'total_retail' => $this->getTotalRetail($store->id),
                    'updated_by' => Auth::user()->id,
                ]);

                if($update){
                    DB::commit(); 
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
             }else{
                 DB::rollback();
                 return 0;
             }
         }catch(\Exception $e){
             DB::rollback();
             return 0;
        } 
    }

    public function getItemRetailPrice($item_id)
    {
           $item = Item::where('id',$item_id)->pluck('retail_price');
           return $item[0];
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
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $data = Deliveries::query()->with('supplier')->whereIn('status', [1,0,3,4,5])->orderBy('id','DESC');

        if($request->query('form_action') === 'search'){

            if(!is_null($supplier_id)) {
                $data->where('supplier_id',  $supplier_id);
            }

            if(!is_null($from_date) && !is_null($to_date)) {
                $data->whereBetween('created_at', [$from_date, $to_date]);
            }
        }

        $listData = $data->paginate($pageSize);  

        return view('admin.po.delivery',compact('listData', 'pageSize', 'suppliers'));
    }
    
    public function getTotalCost($delivery_id)
    {
       return $query = DeliveryItems::where('delivery_id', $delivery_id)->where('status', 1)->sum('total_cost');
    }

    public function getTotalRetail($delivery_id)
    {
        return $query = DeliveryItems::where('delivery_id', $delivery_id)->where('status', 1)->sum('total_retail');
    }  

    public function editDelivery($id)
    {
        $title = 'Edit Delivery';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        
        $data = Deliveries::where('id',decrypt($id))->first();

        $itemList = $this->getDeliveryItems(decrypt($id));
     
        return view('admin.po.edit-delivery',compact('data', 'title', 'itemList',
                'departments', 'sub_departments', 'suppliers'));
    }

    public function getDeliveryItems($delivery_id)
    {
        $itemList = DeliveryItems::with('item', 'item.suppliers.suppliername', 'item.department', 'item.subdepartment')
        ->where('delivery_id', $delivery_id)->where('status', 1)->get();

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
                    'delivery_id' => $value['delivery_id'],
                    'name' => $name,
                    'item_cost' => $value['item_cost'],
                    'retail' => $value['item_retail'],
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

    public function updateDelivery(Request $request)
    {
        $response = array();

         try{
             DB::beginTransaction();
             
             $update = Deliveries::where('id', $request->input('delivery_id'))->update([
                'delivery_date' => $request->input('delivery_date'),
                'supplier_id' => $request->input('supplier'),
                'reference' => $request->input('remark'),
                'status' => $request->input('status'),
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit(); 
            
            return redirect()->route('admin.deliveries')->with('success','Updated successfully!');
         }catch(\Exception $e){
             DB::rollback();
             return redirect()->route('admin.deliveries')->with('error','Something went wrong!');
        } 
    }
    
    public function deliveryItemUpdate(Request $request)
    {
        $response = array();
        $item_id = $request->input('item_id');
        $qty = $request->input('qty');
        $delivery_id = $request->input('delivery_id');
        $actual_cost = $request->input('actual_cost');
        $actual_retail = $request->input('actual_retail');

            try{
                DB::beginTransaction();
                $item_total_cost = $actual_cost * $qty;
                $item_total_retail = $actual_retail * $qty;

                $update = DeliveryItems::where('id', $item_id)->update([
                    'item_cost' => $actual_cost,
                    'item_retail' => $actual_retail,
                    'qty' => $qty,
                    'total_cost' => $item_total_cost,
                    'total_retail' => $item_total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){

                    $total_cost = $this->getTotalCost($delivery_id);
                    $total_retail = $this->getTotalRetail($delivery_id);
                    
                    $request->request->add([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);

                    $updatePriceInfo = $this->updateDeliveryPriceInfo($request);
                    $getItemList = $this->getDeliveryItems($delivery_id);
                    
                    if($updatePriceInfo){
                        DB::commit(); 

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getItemList;
                        $response['total_retail'] = $total_retail;
                        $response['total_cost'] = $total_cost;
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                        $response['msg'] = 'Something went wrong !';
                    }
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
    
    public function updateDeliveryPriceInfo(Request $request)
    {
        $response = array();
        $delivery_id = $request->input('delivery_id');

            try{
                DB::beginTransaction();

                $update = Deliveries::where('id', $delivery_id)->update([
                    'total_cost' => floatval($request->input('total_cost')),
                    'total_retail' => floatval($request->input('total_retail')),
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

    public function addDeliveryItems(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');
        $delivery_id = $request->input('delivery_id');

        try{
            DB::beginTransaction();

            $itemDetails = Item::where('id',$id)->first();
            $actual_cost = $itemDetails['cost_price'];
            $actual_retail = $itemDetails['retail_price'];

            if($ischecked === 'true'){
                $is_checked = 1;
   
                $qty = 1;
                $total_cost = $actual_cost * $qty;
                $total_retail = $actual_retail * $qty;
         
                $store = DeliveryItems::create([
                    'delivery_id' => $delivery_id,
                    'item_id' => $id,
                    'item_cost' => $actual_cost,
                    'item_retail' => $actual_retail,
                    'qty' => 1,
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail,
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
                                $lastInsert = DeliveryItems::where('delivery_id', $delivery_id)->where('status', 1)->orderBy('id', 'desc')->first();
         
                                if(empty($lastInsert)){
                                    $subItemOrder = 1;
                                }else{
                                    $lastInsert = $lastInsert['order'];
                                    $subItemOrder = $lastInsert + 1;
                                }
                    
                                $store = DeliveryItems::create([
                                    'delivery_id' => $delivery_id,
                                    'item_id' => $value['subitem']['id'],
                                    'item_cost' => $value['subitem']['cost_price'],
                                    'item_retail' => $value['subitem']['retail_price'],
                                    'qty' => 1,
                                    'total_cost' => $value['subitem']['cost_price'],
                                    'total_retail' => $value['subitem']['retail_price'],
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

                $store = DeliveryItems::where('delivery_id', $delivery_id)
                            ->where('item_id', $id)->where('status', 1)->update([
                                'status' => $is_checked,
                                'updated_by' => Auth::user()->id
                            ]);
            }

            DB::commit(); 
            $total_cost = $this->getTotalCost($delivery_id);
            $total_retail = $this->getTotalRetail($delivery_id);

            if($store){

                $request->request->add([
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail
                ]);

                $updatePriceInfo = $this->updateDeliveryPriceInfo($request);
                $getItemList = $this->getDeliveryItems($delivery_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
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
    
    public function deleteDeliveryItem(Request $request)
    {
        $response = array();
        $id = $request->input('id');
        $delivery_id = $request->input('delivery_id');

            try{
                DB::beginTransaction();

                $update = DeliveryItems::where('id', $id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);

                $total_cost = $this->getTotalCost($delivery_id);
                $total_retail = $this->getTotalRetail($delivery_id);

                if($update){

                    $request->request->add([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);
    
                    $updatePriceInfo = $this->updateDeliveryPriceInfo($request);
                    $getItemList = $this->getDeliveryItems($delivery_id);

                    DB::commit(); 

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getItemList;
                    $response['total_cost'] = $total_cost;
                    $response['total_retail'] = $total_retail;
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

    public function suspend(Request $request)
    {
        $response = array();
        $delivery_id = $request->input('delivery_id');

            try{
                DB::beginTransaction();

                $update = Deliveries::where('id', $delivery_id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);
                DB::commit(); 

                if($update){
                    $response['code'] = 1;
                }else{
                    DB::rollback();
                    $response['code'] = 0;
                }

                return json_encode($response);
            }catch(\Exception $e){
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = $e->getMessage();
                return json_encode($response);
            } 
    }

    public function updateStock(Request $request)
    {
        $response = array();
        $delivery_id = $request->input('delivery_id');
        $type = $request->input('type');

         try{
            DB::beginTransaction();

            // if($type === 'delivery'){

                $deliveryItems = DeliveryItems::where('delivery_id', $delivery_id)->where('status', 1)->get();

                foreach($deliveryItems as $value)
                {
                    $item_id = $value['item_id'];
                    $qty = $value['qty'];
                    $delivery_item_cost = $value['item_cost'];
                    $delivery_item_retail = $value['item_retail'];
    
                    $getItem = Item::with('department')->where('id', $item_id)->where('status', 1)->first();
    
                    if($getItem){
                        $cost_price = $getItem['cost_price'];
                        $retail_price = $getItem['retail_price'];

                        $vat = VAT::where('id', $getItem['department']['vat_id'])->where('status', 1)->pluck('value');

                        $request->request->add([
                            'id' => $item_id,
                            'retail_price' => $delivery_item_retail,
                            'cost_price' => $delivery_item_cost,
                            'case_size' => $getItem['case_size'],
                            'vat' => $vat[0]
                        ]);

                        $margin = app('App\Http\Controllers\ItemController')->calculateMargin($request);

                        $updateItemDetails = Item::where('id', $item_id)->update([
                            'cost_price' => $delivery_item_cost,
                            'retail_price' => $delivery_item_retail,
                            'margin' => json_decode($margin),
                            'updated_by' => Auth::user()->id
                        ]);

                        if($updateItemDetails){

                            $checkExistingStock = ItemStock::where('item_id', $item_id)->where('status', 1)->first();

                            if($checkExistingStock['qty'] != $qty){

                                $updateStock = ItemStock::where('item_id', $item_id)->update([
                                    'status' => 0,
                                    'updated_by' => Auth::user()->id
                                ]);   
                              
                                $updateStock = ItemStock::create([
                                    'item_id' => $item_id,
                                    'qty' => $qty,
                                    'created_by' => Auth::user()->id,
                                    'updated_by' => Auth::user()->id,
                                ]);
                                
                                if(!$updateStock){
                                    DB::rollback();
                                    $response['code'] = 0;
                                }
                            }

                            if($cost_price != $delivery_item_cost || $retail_price != $delivery_item_retail){

                                $addLog = PriceChangeLog::create([
                                    'item_id' => $item_id,
                                    'old_cost_price' => $cost_price,
                                    'new_cost_price' => $delivery_item_cost,
                                    'old_retail_price' => $retail_price,
                                    'new_retail_price' => $delivery_item_retail,
                                    'created_by' => Auth::user()->id,
                                    'updated_by' => Auth::user()->id,
                                ]);
                                $notification = 'Item price has been changed. Please go and check the more details.';
                                $addNotification = app('App\Http\Controllers\NotificationController')->store(1, $item_id, $notification);
                            }

                            DB::commit(); 
                            $response['code'] = 1;
                        }else{
                            DB::rollback();
                            $response['code'] = 0;
                        }
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                    }
                }
            // }
            return json_encode($response);
         }catch(\Exception $e){
             DB::rollback();
             $response['code'] = 0;
             return json_encode($response);
        } 
    }
    
    public function createDeliveryView()
    {
        $title = 'Add New Purchase Delivery';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        return view('admin.po.create-delivery', compact(
            'title', 'suppliers', 'departments', 'sub_departments'));
    }

    public function storeDelivery(Request $request)
    {
        $response = array();
        $type = $request->input('type');

         try{
             DB::beginTransaction();

             $store = Po::updateOrCreate(
                 [
                     'id'=>$request->input('po_id')
                 ],[
                     'supplier_id' => $request->input('supplier'),
                     'type' => $type,
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id
                 ]
             );

            $delivery_id = $store->id;
 
             if($store){
                    $request->request->add([
                            'delivery_id' => $delivery_id
                        ]);

                    if($type === 'Import'){
                        $query = $this->importDelivery($request);

                        if($query){
                            DB::commit(); 
                            $response['code'] = 1;
                            $response['msg'] = "Success";
                        }else{
                            DB::rollback();
                            $response['code'] = 0;
                            $response['msg'] = 'Something went wrong !';
                        }
                    }else{
                        DB::commit(); 
                        $response['code'] = 1;
                        $response['msg'] = "Success";
                    }
                    
                    $total_cost = $this->getTotalCost($delivery_id);
                    $total_retail = $this->getTotalRetail($delivery_id);

                    $request->request->add([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);
    
                    $updatePriceInfo = $this->updateDeliveryPriceInfo($request);
                    $getItemList = $this->getDeliveryItems($delivery_id);
                    
                    $response['data'] = $getItemList;
                    $response['delivery_id'] = $delivery_id;
                    $response['total_cost'] = $total_cost;
             }else{
                 DB::rollback();
                 $response['code'] = 0;
             }
               
             return json_encode($response);
         }catch(\Exception $e){
             DB::rollback();
             $response['code'] = 0;
             $response['msg'] =  $e->getMessage();
             return json_encode($response);
        } 
    }

    public function importDelivery(Request $request)
    {
       return Excel::import(new DeliveryImport,request()->file('file'));
    }

    public function stockAdjustmentList(Request $request)
    {
        $listData = StockAdjustment::with('created_user')->where('status', 1)->orderBy('id','DESC')->get();
        return view('admin.stock.index',compact('listData'));
    }

    public function createStockAdjustment()
    {
        $title = 'Add New Stock Adjustment';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        return view('admin.stock.add', compact('title', 'suppliers', 'departments', 'sub_departments'));
    }

    public function storeStockAdjustment(Request $request)
    {
        $response = array();

         try{
             DB::beginTransaction();

             $store = StockAdjustment::updateOrCreate(
                 [
                     'id'=>$request->input('stock_adjustment_id')
                 ],[
                     'type' => $request->input('type'),
                     'comment' => $request->input('comment'),
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id
                 ]
             );

            $stock_adjustment_id = $store->id;
 
             if($store){
                  
                DB::commit(); 
                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $stock_adjustment_id;
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

    public function addStockAdjustmentItems(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');
        $stock_adjustment_id = $request->input('stock_adjustment_id');

        try{
            DB::beginTransaction();

            $itemDetails = Item::where('id',$id)->first();
            $actual_cost = $itemDetails['cost_price'];
            $retail_price = $itemDetails['retail_price'];

            if($ischecked === 'true'){
                $is_checked = 1;
   
                $qty = 1;
                $total_cost = $actual_cost * $qty;
                $total_retail = $retail_price * $qty;
         
                $store = StockAdjustmentItems::create([
                    'stock_adjustment_id' => $stock_adjustment_id,
                    'item_id' => $id,
                    'item_cost' => $actual_cost,
                    'item_retail' => $retail_price,
                    'qty' => 0,
                    'stock_before' => app('App\Http\Controllers\ItemController')->getCurrentStockCount($id),
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail,
                    'status' => $is_checked,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
            }else{

                $is_checked = 0;

                $store = StockAdjustmentItems::where('stock_adjustment_id', $stock_adjustment_id)
                        ->where('item_id', $id)->where('status', 1)->update([
                        'status' => $is_checked,
                        'updated_by' => Auth::user()->id
                    ]);
            }

            DB::commit(); 
            $total_cost = $this->getAdjustmentTotalCost($stock_adjustment_id);
            $total_retail = $this->getAdjustmentTotalRetail($stock_adjustment_id);

            if($store){
                $request->request->add([
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail
                ]);

                $updatePriceInfo = $this->updateAdjstmentPriceInfo($request);
                $getItemList = $this->getAdjustmentItems($stock_adjustment_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
            }else{
                DB::rollback();
                $response['code'] = 66;
            }
              
            return json_encode($response);
        }catch(\Exception $e){
            DB::rollback();
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function getAdjustmentItems($stock_adjustment_id)
    {
        $itemList = StockAdjustmentItems::with('adjustment', 'item', 'item.suppliers.suppliername', 'item.department', 'item.subdepartment')
        ->where('stock_adjustment_id', $stock_adjustment_id)->where('status', 1)->get();

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
                $type =  $value['adjustment']['type'];
                $stock_after =  $value['stock_before'];

                
                if($type === 'Stock Adjustment (+)'){
                    $stock_after = $value['stock_before'] +  $value['qty'];
                }else{
                    $stock_after = $value['stock_before'] -  $value['qty'];
                }
       
                $data2 = ([
                    'id' => $value['id'],
                    'item_id' => $item_id,
                    'stock_adjustment_id' => $value['stock_adjustment_id'],
                    'name' => $name,
                    'item_cost' => $value['item_cost'],
                    'retail' => $value['item_retail'],
                    'qty' => $value['qty'],
                    'type' => $value['adjustment']['type'],
                    'stock_before' => $value['stock_before'],
                    'total_cost' => $value['total_cost'],
                    'total_retail' => $value['total_retail'],
                    'supplier' => implode(" ",$supplierList),
                    'department' => $value['item']['department']['name'],
                    'sub_department' => $value['item']['subdepartment']['name'],
                    'type' => $type,
                    'stock_after' => $stock_after
                    ]);

            array_push($itemsArr, $data2);
        }
     return $itemsArr;
    }

    public function getAdjustmentTotalCost($stock_adjustment_id)
    {
        $query = StockAdjustmentItems::where('stock_adjustment_id', $stock_adjustment_id)->where('status', 1)->sum('total_cost');
        return $query;
    }

    public function getAdjustmentTotalRetail($stock_adjustment_id)
    {
        $query = StockAdjustmentItems::where('stock_adjustment_id', $stock_adjustment_id)->where('status', 1)->sum('total_retail');
        return $query;
    }

    public function updateAdjstmentPriceInfo(Request $request)
    {
        $response = array();
        $stock_adjustment_id = $request->input('stock_adjustment_id');

            try{
                DB::beginTransaction();

                $update = StockAdjustment::where('id', $stock_adjustment_id)->update([
                    'total_cost' => floatval($request->input('total_cost')),
                    'total_retail' => floatval($request->input('total_retail')),
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

    public function deleteStockAdjustmentItem(Request $request)
    {
        $response = array();
        $id = $request->input('id');
        $stock_adjustment_id = $request->input('stock_adjustment_id');

            try{
                DB::beginTransaction();

                $update = StockAdjustmentItems::where('id', $id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);

                $total_cost = $this->getAdjustmentTotalCost($stock_adjustment_id);
                $total_retail = $this->getAdjustmentTotalRetail($stock_adjustment_id);    

                if($update){

                    $request->request->add([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);

                    $updatePriceInfo = $this->updateAdjstmentPriceInfo($request);
                    $getItemList = $this->getAdjustmentItems($stock_adjustment_id);
                    
                    DB::commit(); 

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getItemList;
                    $response['total_cost'] = $total_cost;
                    $response['total_retail'] = $total_retail;
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

    public function StockAdjustmentItemUpdate(Request $request)
    {
        $response = array();
        $item_id = $request->input('item_id');
        $qty = $request->input('qty');
        $stock_adjustment_id = $request->input('stock_adjustment_id');
        $actual_cost = $request->input('actual_cost');
        $actual_retail = $request->input('retail');

            try{
                DB::beginTransaction();
                $item_total_cost = $actual_cost * $qty;
                $item_total_retail = $actual_retail * $qty;

                $update = StockAdjustmentItems::where('id', $item_id)->update([
                    'item_cost' => $actual_cost,
                    'item_retail' => $actual_retail,
                    'qty' => $qty,
                    'total_cost' => $item_total_cost,
                    'total_retail' => $item_total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){

                    $total_cost = $this->getAdjustmentTotalCost($stock_adjustment_id);
                    $total_retail = $this->getAdjustmentTotalRetail($stock_adjustment_id);   
                    
                    $request->request->add([
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);

                    $updatePriceInfo = $this->updateAdjstmentPriceInfo($request);
                    $getItemList = $this->getAdjustmentItems($stock_adjustment_id);
                    
                    if($updatePriceInfo){
                        DB::commit(); 

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getItemList;
                        $response['total_retail'] = $total_retail;
                        $response['total_cost'] = $total_cost;
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                        $response['msg'] = 'Something went wrong !';
                    }
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

    public function stockAdjustmentUpdateStock(Request $request)
    {
        $response = array();
        $stock_adjustment_id = $request->input('stock_adjustment_id');

         try{
            DB::beginTransaction();

                $items = StockAdjustmentItems::with('adjustment')->where('stock_adjustment_id', $stock_adjustment_id)->where('status', 1)->get();

                foreach($items as $value)
                {
                    $item_id = $value['item_id'];
                    $qty = $value['qty'];
                    $stock_before = $value['stock_before'];
                    $type =  $value['adjustment']['type'];

                    $getItem = Item::with('department')->where('id', $item_id)->where('status', 1)->first();
    
                    if($getItem){
                        $cost_price = $getItem['cost_price'];
                        $retail_price = $getItem['retail_price'];
                
                        $checkExistingStock = ItemStock::where('item_id', $item_id)->where('status', 1)->first();

                       if(!empty($checkExistingStock)){
                        $existingStock = $checkExistingStock['qty'];

                       }else{
                        $existingStock = 0;
                       }

                        if($existingStock != $qty){
                            
                            $updateStock = ItemStock::where('item_id', $item_id)->update([
                                'status' => 0,
                                'updated_by' => Auth::user()->id
                            ]);   

                            $current_stock = $stock_before;

                            if($type === 'Stock Adjustment (+)'){
                                $current_stock = $stock_before +  $qty;
                            }else{
                                $current_stock = $stock_before -  $qty;
                            }
                              
                            $updateStock = ItemStock::create([
                                'item_id' => $item_id,
                                'qty' => $current_stock,
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                                
                            if(!$updateStock){
                                DB::rollback();
                                $response['code'] = 0;
                            }
                        }

                        DB::commit(); 
                        $response['code'] = 1;
                    }else{
                        DB::rollback();
                        $response['code'] = 0;
                    }
                }
            return json_encode($response);
         }catch(\Exception $e){
             DB::rollback();
             $response['code'] = 0;
             $response['msg'] = $e->getMessage();
             return json_encode($response);
        } 
    }

    public function viewStockAdjustment($id)
    {
        $title = 'Stock Adjustment Details';

        $data = StockAdjustment::where('id',decrypt($id))->first();
        $itemList = $this->getAdjustmentItems(decrypt($id));
     
        return view('admin.stock.detail',compact('data', 'title', 'itemList'));
    }
}
