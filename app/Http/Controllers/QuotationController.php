<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\Bundle;
use App\Models\QuotationDescription;
use App\Models\QuotationItem;
use App\Models\Item;
use DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize;

        if (!isset($request->pagesize)) {
            $new = 10;
        }else{
            $new = $request->pagesize;
        }

        $pageSize = $new;
        $customers = Customer::where('status', 1)->orderBy('name','ASC')->get();
        $data = Quotation::query()->with('customer')->orderBy('id','DESC');

        if($request->query('form_action') === 'search'){

            if(!is_null($status)) {
                $data->orWhere('status', $status);
            }

            if(!is_null($department)) {
                $data->where('department_id',  $department);
            }

            if(!is_null($sub_department)) {
                $data->where('sub_department_id',  $sub_department);
            }

            if(!is_null($supplierId)) {

                $data->whereHas('suppliers', function($q) use ($supplierId){
                    $q->where('supplier_id', $supplierId);
                });
            }
        }
        $listData = $data->paginate($pageSize);  

        return view('admin.quotation.index',compact('listData', 'pageSize', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add New Quotation';
        $customers = Customer::where('status', 1)->orderBy('name','ASC')->get();
        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        $bundles = Bundle::where('status', 1)->orderBy('id','DESC')->get();
        $descriptions = QuotationDescription::where('status', 1)->orderBy('description','ASC')->get();

        return view('admin.quotation.create', compact(
            'title', 'customers', 'departments', 'sub_departments', 
            'suppliers', 'bundles', 'descriptions'));
    }

    public function store(Request $request)
    {
        $response = array();
        $description = $request->input('description');

         try{
             DB::beginTransaction();

              $checkExist = QuotationDescription::where('description', 'LIKE',"%$description%")->get();

             if(!$checkExist){
                $add = QuotationDescription::create([
                    'description' => $description,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
             }

             $store = Quotation::updateOrCreate(
                 [
                     'id'=>$request->input('quotation_id')
                 ],[
                     'customer_id' => $request->input('customer'),
                     'description' => $request->input('description'),
                     'price' => $request->input('price'),
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id,
                 ]
             );
 
             if($request->input('quotation_id')){
                 $id = $request->input('quotation_id');
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

    public function edit($id)
    {
        $title = 'Edit Quotation';

        $customers = Customer::where('status', 1)->orderBy('name','ASC')->get();
        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        $bundles = Bundle::where('status', 1)->orderBy('id','DESC')->get();
        $descriptions = QuotationDescription::where('status', 1)->orderBy('description','ASC')->get();

        
        $total_cost = $this->getTotalCost(decrypt($id));
        $total_retail = $this->getTotalRetail(decrypt($id));
        $quotation_cost = $this->getQuotationCost(decrypt($id));
        $total_item_cost = $this->getTotalItemCost(decrypt($id));
        $total_item_retail = $this->getTotalItemRetail(decrypt($id));

        $data = Quotation::where('id',decrypt($id))->first();

         $quotationItems = $this->getQuotationItems(decrypt($id));
     
        return view('admin.quotation.edit',compact('data', 'title', 'customers', 'quotationItems',
                'departments', 'sub_departments', 'suppliers', 'bundles', 'descriptions',
                'total_cost', 'total_retail', 'quotation_cost', 'total_item_cost', 'total_item_retail'));
    }

    public function addItems(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');
        $quotation_id = $request->input('quotation_id');

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

                $getLastInsert = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->orderBy('id', 'desc')->first();
     
            if(empty($getLastInsert)){
                        $order = 1;
            }else{
                $lastInsertOrder = $getLastInsert['order'];
                $order = $lastInsertOrder + 1;
            }

                $store = QuotationItem::create([
                    'quotation_id' => $quotation_id,
                    'item_id' => $id,
                    'item_cost' => $actual_cost,
                    'actual_cost' => $actual_cost,
                    'retail' => $retail,
                    'actual_retail' => $retail,
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

                $store = QuotationItem::where('quotation_id', $quotation_id)
                            ->where('item_id', $id)->where('status', 1)->update([
                                'status' => $is_checked,
                                'updated_by' => Auth::user()->id
                            ]);
            }

            DB::commit(); 
            $total_cost = $this->getTotalCost($quotation_id);
            $total_retail = $this->getTotalRetail($quotation_id);
            $quotation_cost = $this->getQuotationCost($quotation_id);
            
            $total_item_cost = $this->getTotalItemCost($quotation_id);
            $total_item_retail = $this->getTotalItemRetail($quotation_id);

            if($store){

                $queryUpdate = Quotation::where('id', $quotation_id)->where('status', 1)->update([
                                'item_cost' => $total_cost,
                                'item_retail' => $total_retail,
                                'updated_by' => Auth::user()->id
                            ]);
                
                $getQuotationItemList = $this->getQuotationItems($quotation_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getQuotationItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
                $response['total_item_cost'] = $total_item_cost;
                $response['total_item_retail'] = $total_item_retail;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
                $response['total_item_cost'] = $total_item_cost;
                $response['total_item_retail'] = $total_item_retail;
            }
              
            return json_encode($response);
        }catch(\Exception $e){
            DB::rollback();
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function getTotalCost($quotation_id)
    {
       return $query = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->sum('total_cost');
    }

    public function getTotalRetail($quotation_id)
    {
        return $query = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->sum('total_retail');
    }

    public function getQuotationCost($quotation_id)
    {
        return $query = Quotation::where('id', $quotation_id)->where('status', 1)->pluck('price');
    }

    public function getTotalItemCost($quotation_id)
    {
       return $query = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->sum('actual_cost');
    }

    public function getTotalItemRetail($quotation_id)
    {
       return $query = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->sum('actual_retail');
    }

    public function getQuotationItems($quotationId)
    {
        $itemList = QuotationItem::with('item', 'item.suppliers.suppliername')
        ->where('quotation_id', $quotationId)->where('status', 1)
        ->orderBy('order','ASC')->get();

        $itemsArr = array();

        foreach($itemList as $value){
            $supplierList = array();
                    
                foreach($value['item']['suppliers'] as $supplier){
                    $supplier = $supplier['suppliername']['name'];
                    array_push($supplierList, $supplier);
                }
                    
                $data2 = ([
                    'id' => $value['id'],
                    'item_id' => $value['item']['id'],
                    'name' => $value['item']['name'],
                    'actual_cost' => $value['item']['cost_price'],
                    'item_cost' => $value['item_cost'],
                    'retail' => $value['retail'],
                    'qty' => $value['qty'],
                    'total_cost' => $value['total_cost'],
                    'total_retail' => $value['total_retail'],
                    'display_report' => $value['display_report'],
                    'quotation_id' => $value['quotation_id'],
                    'supplier' => implode(" ",$supplierList)
                    ]);

            array_push($itemsArr, $data2);
        }
     return $itemsArr;
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

                $update = QuotationItem::where('id', $id)->update([
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
        $quotation_id = $request->input('quotation_id');

            try{
                DB::beginTransaction();

                $update = QuotationItem::where('id', $id)->update([
                    'status' => 0,
                    'updated_by' => Auth::user()->id
                ]);

                $total_cost = $this->getTotalCost($quotation_id);
                $total_retail = $this->getTotalRetail($quotation_id);
                $quotation_cost = $this->getQuotationCost($quotation_id);
                $total_item_cost = $this->getTotalItemCost($quotation_id);
                $total_item_retail = $this->getTotalItemRetail($quotation_id);
                
                $queryUpdate = Quotation::where('id', $quotation_id)->where('status', 1)->update([
                    'item_cost' => $total_cost,
                    'item_retail' => $total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                DB::commit(); 

                if($update){
                   
                    $getQuotationItemList = $this->getQuotationItems($quotation_id);

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getQuotationItemList;
                    $response['total_cost'] = $total_cost;
                    $response['total_retail'] = $total_retail;
                    $response['quotation_cost'] = $quotation_cost;
                    $response['total_item_cost'] = $total_item_cost;
                    $response['total_item_retail'] = $total_item_retail;
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

            $queryStatus = Quotation::find($id);
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
        $quotation_item_id = $request->input('quotation_item_id');
        $actual_cost = $request->input('actual_cost');
        $qty = $request->input('qty');
        $quotation_id = $request->input('quotation_id');
        $retail = $request->input('retail');

            try{
                DB::beginTransaction();
                $item_total_cost = $actual_cost * $qty;
                $item_total_retail = $retail * $qty;

                $update = QuotationItem::where('id', $quotation_item_id)->update([
                    'item_cost' => $actual_cost,
                    'qty' => $qty,
                    'retail' => $retail,
                    'total_cost' => $item_total_cost,
                    'total_retail' => $item_total_retail,
                    'updated_by' => Auth::user()->id
                ]);

                if($update){

                    $total_cost = $this->getTotalCost($quotation_id);
                    $total_retail = $this->getTotalRetail($quotation_id);
                    $quotation_cost = $this->getQuotationCost($quotation_id);
                    $total_item_cost = $this->getTotalItemCost($quotation_id);
                    $total_item_retail = $this->getTotalItemRetail($quotation_id);
          
                    $queryUpdate = Quotation::where('id', $quotation_id)->where('status', 1)->update([
                        'item_cost' => $total_cost,
                        'item_retail' => $total_retail,
                        'updated_by' => Auth::user()->id
                    ]);
                    
                    if($queryUpdate){
                        DB::commit(); 
                   
                        $getItemList = $this->getQuotationItems($quotation_id);

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getItemList;
                        $response['total_cost'] = $total_cost;
                        $response['total_retail'] = $total_retail;
                        $response['quotation_cost'] = $quotation_cost;
                        $response['total_item_cost'] = $total_item_cost;
                        $response['total_item_retail'] = $total_item_retail;
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
}
