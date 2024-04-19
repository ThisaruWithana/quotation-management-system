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
use App\Models\BundleItem;
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
        $customer = $request->input('customer');

        if($request->query('form_action') === 'search'){

            if(!is_null($customer)) {
                $data->where('customer_id',  $customer);
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
        $vat_rate = app('App\Http\Controllers\VatController')->getLatestVatRate();

        return view('admin.quotation.create', compact(
            'title', 'customers', 'departments', 'sub_departments', 
            'suppliers', 'bundles', 'descriptions', 'vat_rate'));
    }

    public function store(Request $request)
    {
        $response = array();
        $description = $request->input('description');

         try{
             DB::beginTransaction();

              $checkExist = QuotationDescription::where('description', 'LIKE',"%$description%")->get();
              $vatRate = app('App\Http\Controllers\VatController')->getLatestVatRate();

             if(count($checkExist) == 0){
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
                     'discount' => $request->input('discount'),
                     'vat_rate' => floatval($vatRate[0]),
                     'price' => $request->input('price'),
                     'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id,
                 ]
             );
 
             if($request->input('quotation_id')){
                 $id = $request->input('quotation_id');
                 $referenceNo = '';

                 $this->updatePriceInfo($request);
             }else{
                 $id = $store->id;
                 $referenceNo = $this->generateQuotationReference($id, $request->input('customer'));

                 $update = Quotation::where('id', $id)->update([
                    'ref' => $referenceNo,
                    'updated_by' => Auth::user()->id
                ]);
             }
 
             DB::commit(); 
 
             if($store){
                 $response['code'] = 1;
                 $response['msg'] = "Success";
                 $response['data'] = $id;
                 $response['ref'] = $referenceNo;
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
        $descriptions = QuotationDescription::where('status', 1)->orderBy('description','ASC')->get();

        $selectedBundles = QuotationItem::where('status', 1)->where('type','bundle')->pluck('item_id');
        $bundles = Bundle::whereNotIn('id', $selectedBundles)->where('status', 1)->orderBy('id','DESC')->get();

        $total_cost = $this->getTotalCost(decrypt($id));
        $total_retail = $this->getTotalRetail(decrypt($id));
        $quotation_cost = $this->getQuotationCost(decrypt($id));
       
        $vatAmt = $this->getVATAmt($quotation_cost[0]);
        
        $data = Quotation::where('id',decrypt($id))->first();

        $quotationItems = $this->getQuotationItems(decrypt($id));
     
        return view('admin.quotation.edit',compact('data', 'title', 'customers', 'quotationItems',
                'departments', 'sub_departments', 'suppliers', 'bundles', 'descriptions',
                'total_cost', 'total_retail', 'quotation_cost', 'vatAmt'));
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

            if($store){

                $request->request->add([
                    'price' => $quotation_cost,
                    'price_after_discount' => $this->getPriceAfterDiscount($quotation_id),
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail,
                ]);

                $updatePriceInfo = $this->updatePriceInfo($request);
                $getQuotationItemList = $this->getQuotationItems($quotation_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getQuotationItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
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

    public function getVATAmt($quotation_cost)
    {
        $vatRate = app('App\Http\Controllers\VatController')->getLatestVatRate();
        $vat = ($quotation_cost* floatval($vatRate[0])) / 100;
        return $vat;
    }

    public function getPriceAfterDiscount($quotation_id)
    {
         $query = Quotation::where('id', $quotation_id)->where('status', 1)->first();

        if($query){
             $quotationPrice = $query['price'];
             $discount = $query['discount'];

             return $priceAfterDiscount = $quotationPrice - ((floatval($quotationPrice) * $discount)/100);
        }
    }


    public function getQuotationMarginAmt($quotation_id, $quotation_cost)
    {
        $quotationCost = floatval($quotation_cost);
        $total_cost = Quotation::where('id', $quotation_id)->where('status', 1)->pluck('total_cost');
        $margin =  floatval($quotation_cost) - floatval($total_cost[0]);

        return $margin;
    }

    public function getQuotationMarginRate($quotation_cost, $quotation_margin)
    {
       return $margin_rate = round(($quotation_margin/floatval($quotation_cost)) * 100, 2);
    }

    public function getQuotationItems($quotationId)
    {
        $itemList = QuotationItem::with('item', 'item.suppliers.suppliername')
        ->where('quotation_id', $quotationId)->where('status', 1)
        ->orderBy('order','ASC')->get();

        $itemsArr = array();

        foreach($itemList as $value){
            $supplierList = array();

            if($value['type'] != 'item'){

                $bundle = Bundle::where('id', $value['item_id'])->where('status', 1)->first();

                $name = $bundle['name'];
                $item_id = $bundle['id'];
                $actual_cost = $bundle['bundle_cost'];

            }else{
                foreach($value['item']['suppliers'] as $supplier){
                    $supplier = $supplier['suppliername']['name'];
                    array_push($supplierList, $supplier);
                }

                $name = $value['item']['name'];
                $item_id = $value['item']['id'];
                $actual_cost = $value['item']['cost_price'];
            }
                    
                $data2 = ([
                    'id' => $value['id'],
                    'item_id' => $item_id,
                    'quotation_id' => $value['quotation_id'],
                    'name' => $name,
                    'actual_cost' => $actual_cost,
                    'item_cost' => $value['item_cost'],
                    'retail' => $value['retail'],
                    'qty' => $value['qty'],
                    'total_cost' => $value['total_cost'],
                    'total_retail' => $value['total_retail'],
                    'display_report' => $value['display_report'],
                    'quotation_id' => $value['quotation_id'],
                    'type' => $value['type'],
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

                DB::commit(); 

                if($update){

                    $request->request->add([
                        'price' => $quotation_cost,
                        'price_after_discount' => $this->getPriceAfterDiscount($quotation_id),
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);
    
                    $queryUpdate = $this->updatePriceInfo($request);
                    $getQuotationItemList = $this->getQuotationItems($quotation_id);

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $getQuotationItemList;
                    $response['total_cost'] = $total_cost;
                    $response['total_retail'] = $total_retail;
                    $response['quotation_cost'] = $quotation_cost;
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
                    
                    $request->request->add([
                        'price' => $quotation_cost,
                        'price_after_discount' => $this->getPriceAfterDiscount($quotation_id),
                        'total_cost' => $total_cost,
                        'total_retail' => $total_retail
                    ]);

                    $queryUpdate = $this->updatePriceInfo($request);
                    
                    if($queryUpdate){
                        DB::commit(); 
                   
                        $getItemList = $this->getQuotationItems($quotation_id);

                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $getItemList;
                        $response['total_cost'] = $total_cost;
                        $response['total_retail'] = $total_retail;
                        $response['quotation_cost'] = $quotation_cost;
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

    public function generateQuotationReference($quotation_id, $customer_id)
    {
        $query = Quotation::where('customer_id', $customer_id)->where('status', 1)->get();
        $quotationCount = count($query);

        if($quotationCount > 1){
            $count = $quotationCount + 1;
        }else{
            $count = 1;
        }

        $referenceNo = $quotation_id.'-'.$count.'-'.date('Ymd');

       return $referenceNo;
    }

    public function updatePriceInfo(Request $request)
    {
        $response = array();
        $quotation_id = $request->input('quotation_id');
        $margin_amount = $this->getQuotationMarginAmt($quotation_id, $request->input('price_after_discount'));
        $margin_rate = $this->getQuotationMarginRate($request->input('price_after_discount'), $margin_amount);

            try{
                DB::beginTransaction();
                $vatRate = app('App\Http\Controllers\VatController')->getLatestVatRate();

                $update = Quotation::where('id', $quotation_id)->update([
                    'price' => $request->input('price'),
                    'discount' => $request->input('discount'),
                    'margin' => $margin_rate,
                    'vat_rate' => floatval($vatRate[0]),
                    'vat_amt' => floatval($request->input('vat')),
                    'total_cost' => floatval($request->input('total_cost')),
                    'total_retail' => floatval($request->input('total_retail')),
                    'quotation_vat' => floatval($request->input('quotation_vat')),
                    'quotation_margin' => $margin_amount,
                    'final_price' => floatval($request->input('quotation_vat')),
                    'updated_by' => Auth::user()->id
                ]);

                if($update){
                    DB::commit(); 
                   
                    $getItemList = $this->getQuotationItems($quotation_id);

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

    public function addBundle(Request $request)
    {
        $response = array();
        $bundle = $request->input('bundle');
        $quotation_id = $request->input('quotation_id');

        try{
            DB::beginTransaction();

            $bundleDetails = Bundle::where('id',$bundle)->first();
            $total_cost = $bundleDetails['total_cost'];
            $total_retail = $bundleDetails['total_retail'];
            $bundle_cost = $bundleDetails['bundle_cost'];

            $getLastInsert = QuotationItem::where('quotation_id', $quotation_id)->where('status', 1)->orderBy('id', 'desc')->first();
     
            if(empty($getLastInsert)){
                $order = 1;
            }else{
                $lastInsertOrder = $getLastInsert['order'];
                $order = $lastInsertOrder + 1;
            }
            $store = QuotationItem::create([
                'quotation_id' => $quotation_id,
                'item_id' => $bundle,
                'item_cost' => $bundle_cost,
                'actual_cost' => $bundle_cost,
                'retail' => $total_retail,
                'actual_retail' => $total_retail,
                'qty' => 1,
                'total_cost' => $bundle_cost,
                'total_retail' => $total_retail,
                'order' => $order,
                'status' => 1,
                'type' => 'bundle',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            DB::commit(); 

            $total_cost = $this->getTotalCost($quotation_id);
            $total_retail = $this->getTotalRetail($quotation_id);
            $quotation_cost = $this->getQuotationCost($quotation_id);

            if($store){

                $request->request->add([
                    'price' => $quotation_cost,
                    'total_cost' => $total_cost,
                    'price_after_discount' => $this->getPriceAfterDiscount($quotation_id),
                    'total_retail' => $total_retail
                ]);

                $updatePriceInfo = $this->updatePriceInfo($request);
                
                $getQuotationItemList = $this->getQuotationItems($quotation_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getQuotationItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
                $response['bundle_cost'] = $bundle_cost;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
            }
              
            return json_encode($response);
        }catch(\Exception $e){
            DB::rollback();
            $response['code'] = 0;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        } 
    }

    public function editBundle(Request $request)
    {
        $response = array();
        $bundle_id = $request->input('bundle_id');
        $quotation_id = $request->input('quotation_id');

        try{
            DB::beginTransaction();
            
            // Disable existing bundle
            $update = QuotationItem::where('quotation_id', $quotation_id)->where('item_id', $bundle_id)->update([
                'status' => 0,
                'updated_by' => Auth::user()->id
            ]);

            if($update){

                $bundleItemList = BundleItem::with('item', 'item.suppliers.suppliername')->where('bundle_id',$bundle_id)->where('status',1)->get();

                foreach($bundleItemList as $value){
                    
                    // Add bundle items to quotation
                    $store = QuotationItem::create([
                        'quotation_id' => $quotation_id,
                        'item_id' => $value['item']['id'],
                        'item_cost' => $value['item_cost'],
                        'actual_cost' => $value['actual_cost'],
                        'retail' => $value['total_retail'],
                        'actual_retail' => $value['retail'],
                        'qty' => $value['qty'],
                        'total_cost' => $value['total_cost'],
                        'total_retail' => $value['total_retail'],
                        'order' => $value['order'],
                        'display_report' => $value['display_report'],
                        'status' => 1,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);

                }
            }

            DB::commit(); 
            $total_cost = $this->getTotalCost($quotation_id);
            $total_retail = $this->getTotalRetail($quotation_id);
            $quotation_cost = $this->getQuotationCost($quotation_id);

            if($store){

                $request->request->add([
                    'price' => $quotation_cost,
                    'price_after_discount' => $this->getPriceAfterDiscount($quotation_id),
                    'total_cost' => $total_cost,
                    'total_retail' => $total_retail
                ]);

                $updatePriceInfo = $this->updatePriceInfo($request);
                $getQuotationItemList = $this->getQuotationItems($quotation_id);

                $response['code'] = 1;
                $response['msg'] = "Success";
                $response['data'] = $getQuotationItemList;
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
            }else{
                DB::rollback();
                $response['code'] = 0;
                $response['msg'] = 'Something went wrong !';
                $response['data'] = '';
                $response['total_cost'] = $total_cost;
                $response['total_retail'] = $total_retail;
                $response['quotation_cost'] = $quotation_cost;
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
