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
use App\Models\SubItem;
use App\Models\BundleItem;
use App\Models\QuotationItem;
use App\Models\OpfItems;
use App\Models\PoItems;
use App\Models\DeliveryItems;
use App\Models\ItemStock;
use App\Models\StockAdjustmentItems;
use App\Models\StockTakeItems;
use DB;
use Auth;
use PDF;

class ItemController extends Controller
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
        $status = $request->input('status');
        $supplierId = $request->input('supplier');
        $department = $request->input('departments');
        $sub_department = $request->input('sub_departments');
        
        $title = 'Item Maintainance';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();

        
        $data = Item::query()->with('created_user', 'department', 'subdepartment', 'barcode', 'suppliers.suppliername')->orderBy('id','desc');

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

        return view('admin.item.index', compact('listData', 'title', 'suppliers', 'departments', 'sub_departments', 'pageSize'));
    }

    public function create()
    {
        $title = 'Add New Item';
        $page = 'add';

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        $locations = Location::where('status', 1)->orderBy('name','ASC')->get();
        $itemList = Item::with('barcode', 'department.vat')->where('status', 1)->get();

        return view('admin.item.create', compact('title', 'page', 'suppliers', 'departments', 'sub_departments', 'locations', 'itemList'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Item';
        $page = 'edit';
        $data = Item::with('barcode', 'department.vat')->where('id',decrypt($id))->first();
        $optionalItems = SubItem::with('subitem.barcode', 'subitem.department')->where('parent_id', decrypt($id))->where('status', 1)->orderBy('id','DESC')->get();

        $suppliers = Supplier::where('status', 1)->orderBy('name','ASC')->get();
        $departments = Department::where('status', 1)->orderBy('name','ASC')->get();
        $sub_departments = SubDepartment::where('status', 1)->orderBy('name','ASC')->get();
        $locations = Location::where('status', 1)->orderBy('name','ASC')->get();
        $itemList = Item::with('barcode', 'department.vat')->where('id', '!=', decrypt($id))->where('status', 1)->get();

        $selectedSuppliers = ItemSupplier::where('item_id', decrypt($id))->where('status', 1)->pluck('supplier_id')->toArray();

        $selectedOptionalItems = SubItem::where('parent_id', decrypt($id))->where('status', 1)->pluck('sub_item_id')->toArray();

        $inStock = $this->getCurrentStockCount(decrypt($id));

        return view('admin.item.edit',compact(
            'data', 'title', 'page', 'suppliers', 'departments', 'sub_departments', 'locations',
            'selectedSuppliers', 'itemList', 'selectedOptionalItems', 'optionalItems', 'inStock'
        ));
    }

    public function store(Request $request)
    {
        $response = array();
        $suppliers = $request->input('supplier');
        $id = $request->input('item_id');

            try{
                DB::beginTransaction();

                if($id != ''){

                    $updateItemDetails = Item::where('id', $id)->update([
                        'department_id' => $request->input('department'),
                        'sub_department_id' => $request->input('sub_department'),
                        'updated_by' => Auth::user()->id
                    ]);

                    
                    $disableSuppliers = ItemSupplier::where('item_id', $id)->update([
                        'status' => 0,
                        'updated_by' => Auth::user()->id
                    ]);

                    foreach($suppliers as $supplier){

                        $addNewSuppliers = ItemSupplier::create([
                            'item_id' => $id,
                            'supplier_id' => $supplier,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }

                }else{
                    
                    $createItem = Item::create([
                        'barcode_id' => 0,
                        'department_id' => $request->input('department'),
                        'sub_department_id' => $request->input('sub_department'),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
    
                    if($createItem){
                    
                        $generateBarcode = $this->generateBarcode();
                        $barcode = $createItem->id.$generateBarcode;
    
                        $createBarcode = Barcode::create([
                            'product_code' => $request->input('product_code'),
                            'barcode' => $barcode,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);

                        $updateBarcode = Item::where('id', $createItem->id)->update([
                            'barcode_id' => $createBarcode->id,
                            'updated_by' => Auth::user()->id
                        ]);
    
                        foreach($suppliers as $supplier){
    
                            $addSuppliers = ItemSupplier::create([
                                'item_id' => $createItem->id,
                                'supplier_id' => $supplier,
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
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
        $id = $request->input('item_id');
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

                  $updateItemDetails = Item::where('id', $id)->update([
                        'min_stock' => $request->input('min_stock'),
                        'location_id' => $request->input('location'),
                        'auto_order' => $auto_order,
                        'status' => $status,
                        'exclude_from_stock' => $exclude_from_stock,
                        'updated_by' => Auth::user()->id,
                    ]);

                    if($request->image){
                       
                        $request->validate([
                            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
                        ]);

                        $imageName = $id.'-'.date("YmdHis").'.'.$request->image->extension();  
                        $upload = $request->image->move(public_path('images'), $imageName);
              
                        if($upload){

                            $updateItemDetails = Item::where('id', $id)->update([
                                'image' => $imageName,
                                'updated_by' => Auth::user()->id
                            ]);
                        }
                    }

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
        $id = $request->input('item_id');
        $response = array();

            try{
                DB::beginTransaction();

                    $updateItemDetails = Item::where('id', $id)->update([
                        'cost_price' => $request->input('cost_price'),
                        'retail_price' => $request->input('retail_price'),
                        'margin' => $request->input('margin'),
                        'case_size' => $request->input('case_size'),
                        'updated_by' => Auth::user()->id,
                    ]);

                if($updateItemDetails){

                    // Update new price to bundle item price
                    
                    $updateBundleItemDetails = BundleItem::where('item_id', $id)->update([
                        'actual_cost' => $request->input('cost_price'),
                        'retail' => $request->input('retail_price'),
                        'updated_by' => Auth::user()->id,
                    ]);

                    if($updateBundleItemDetails){

                        DB::commit();
                        $response['code'] = 1;
                        $response['msg'] = "Success";
                        $response['data'] = $id;
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

            $queryStatus = Item::find($id);
            $queryStatus->status = $status;
            $queryStatus->save();

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        $item_id = $request->input('item_id');
        $suppliers = $request->input('supplier');

        $response = array();

            try{
                DB::beginTransaction();

                    $updateItemDetails = Item::where('id', $item_id)->update([
                        'department_id' => $request->input('department'),
                        'sub_department_id' => $request->input('sub_department'),
                        'updated_by' => Auth::user()->id
                    ]);
                    
                    $disableSuppliers = ItemSupplier::where('item_id', $item_id)->update([
                        'status' => 0,
                        'updated_by' => Auth::user()->id
                    ]);

                    foreach($suppliers as $supplier){
                        $addNewSuppliers = ItemSupplier::create([
                            'item_id' => $item_id,
                            'supplier_id' => $supplier,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                    DB::commit(); 

                    $storeItemDetails = $this->storeItemDetails($request);
                    $updateStockSettings = $this->updateStockSettings($request);
                    $updatePriceDetails = $this->updatePriceDetails($request);

                if($addNewSuppliers){
                    $response['code'] = 1;
                    $response['msg'] = "Successfully updated !";
                    $response['data'] = $item_id;
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

    public function calculateMargin(Request $request)
    {
        $itemId = $request->input('id');
        $retailPrice = $request->input('retail_price');
        $costPrice = $request->input('cost_price');
        $caseSize = $request->input('case_size');
        $vat = $request->input('vat');

        $vatConst = ($vat + 100)/100;
        $netRetail = $retailPrice / $vatConst;
        $netProfit = $netRetail - ($costPrice / $caseSize);
        $margin = ($netProfit / $netRetail) * 100;

        return json_encode(round($margin, 2));
    }

    public function viewItemDetails($id)
    {
        $data = Item::with('barcode', 'department.vat', 'subdepartment', 'location', 'suppliers.suppliername')->where('id',decrypt($id))->first();
        $optionalItems = SubItem::with('subitem.barcode', 'subitem.department')->where('parent_id', decrypt($id))->where('status', 1)->orderBy('id','DESC')->get();

        return view('admin.item.detail',compact('data', 'optionalItems'));
    }

    public function getItems(Request $request)
    {
        $items = $request->input('item_list');

        $data = Item::with('department', 'subdepartment', 'barcode', 'suppliers.suppliername')
                    ->whereIn('id', $items)
                    ->where('status', 1)
                    ->orderBy('id','DESC')->get();

        return json_encode($data);
    }

    public function storeSubItems(Request $request)
    {
        $response = array();
        $item = $request->input('id');
        $parent_id = $request->input('parent_id');

            try{
                DB::beginTransaction();

                    $addItems = SubItem::create([
                        'parent_id' => $parent_id,
                        'sub_item_id' => $item,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                DB::commit(); 

                if($addItems){
                    
                    $data = SubItem::with('subitem.barcode', 'subitem.department')->where('parent_id', $parent_id)
                                    ->where('status', 1)->orderBy('id','DESC')->get();

                    $response['code'] = 1;
                    $response['msg'] = "Success";
                    $response['data'] = $data;
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

    public function updateMandatoryStatus(Request $request)
    {
        $response = array();
        $ischecked = $request->input('ischecked');
        $id = $request->input('id');

            try{
                DB::beginTransaction();

                if($ischecked === 'true'){
                    $is_mandatory = 1;
                }else{
                    $is_mandatory = 0;
                }

                $update = SubItem::where('id', $id)->update([
                    'is_mandatory' => $is_mandatory,
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

    public function downloadBarcode($id)
    {    
        $item = Item::with('barcode')->where('id',decrypt($id))->first();

        $data = [
            'title' => 'Barcode of '.$item['name'],
            'item' => $item['name'],
            'product_code' => $item['barcode']['product_code'],
            'barcode' =>$item['barcode']['barcode']
        ];

        $pdf = PDF::loadView('admin.reports.barcode', $data);
        return $pdf->download($item['name'].'.pdf');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $search_type = $request->input('search_type');
        $status = $request->input('status');
        $supplierId = $request->input('supplier');
        $department = $request->input('departments');
        $sub_department = $request->input('sub_departments');

        if($search_type === 'bundle_search'){

            $bundle_id = $request->input('bundle');
            $getExistBundleItems = BundleItem::select('item_id')->where('bundle_id', $bundle_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistBundleItems)->orderBy('id','desc');
        
        } else if($search_type === 'quotation_search'){

            $quotation_id = $request->input('quotation');
            $getExistItems = QuotationItem::select('item_id')->where('quotation_id', $quotation_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        } else if($search_type === 'opf'){

            $opf_id = $request->input('opf');
            $getExistItems = OpfItems::select('item_id')->where('opf_id', $opf_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        } else if($search_type === 'po'){

            $po_id = $request->input('poId');
            $getExistItems = PoItems::select('item_id')->where('po_id', $po_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        }else if($search_type === 'delivery'){

            $delivery_id = $request->input('deliveryId');
            $getExistItems = DeliveryItems::select('item_id')->where('delivery_id', $delivery_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        }else if($search_type === 'sub_items'){

            $item_id = $request->input('id');
            $getExistItems = SubItem::select('sub_item_id')->where('parent_id', $item_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->where('id', '!=', $item_id)->whereNotIn('id', $getExistItems)->where('status', 1)->orderBy('id','desc');
        } else if($search_type === 'stock'){

            $stock_adjustment_id = $request->input('stock');
            $getExistItems = StockAdjustmentItems::select('item_id')->where('stock_adjustment_id', $stock_adjustment_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        } else if($search_type === 'stock_take'){

            $stock_take_id = $request->input('stock');
            $getExistItems = StockTakeItems::select('item_id')->where('stock_take_id', $stock_take_id)->where('status', 1)->get();

            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->whereNotIn('id', $getExistItems)->orderBy('id','desc');
        
        }else{
            $data = Item::query()->with('suppliers.suppliername', 'department')->where('status', 1)->orderBy('id','desc');
        }

            if(!is_null($status)) {
                $data->where('status', $status);
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

            if(!is_null($keyword)) {

                 $data->where(function ($qry) use ($keyword) {
                    $qry->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%')
                        ->orWhere('id', 'like', '%' . $keyword . '%');
                });
            }

        $listData = $data->get();  

        $response = array();

        foreach($listData as $value){
            $supplierList = array();

            foreach($value['suppliers'] as $supplier){
                $supplier = $supplier['suppliername']['name'];
                array_push($supplierList, $supplier);
            }

            $data = ([
                'id' => $value['id'],
                'name' => $value['name'],
                'department' => $value['department']['name'],
                'cost_price' => $value['cost_price'],
                'retail_price' => $value['retail_price'],
                'supplier' => implode(" ",$supplierList)
            ]);
            array_push($response, $data);
        }
    
        return json_encode($response);
        
    }

    public  function generateBarcode($length = 11) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $uniqueNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $uniqueNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $uniqueNumber;
    }

    public function getSubItems(Request $request)
    {
        $response = array();
        $itemId = $request->input('id');
        $optionalItems = SubItem::with('subitem.department', 'subitem.suppliers')->where('parent_id', $itemId)->where('status', 1)->orderBy('id','DESC')->get();
        
        foreach($optionalItems as $value){
            $supplierList = array();

            foreach($value['subitem']['suppliers'] as $supplier){
                $supplier = $supplier['suppliername']['name'];
                array_push($supplierList, $supplier);
            }

            $data = ([
                'is_mandatory' => $value['is_mandatory'],
                'id' => $value['subitem']['id'],
                'name' => $value['subitem']['name'],
                'department' => $value['subitem']['department']['name'],
                'cost_price' => $value['subitem']['cost_price'],
                'retail_price' => $value['subitem']['retail_price'],
                'supplier' => implode(" ",$supplierList)
            ]);
            array_push($response, $data);
        }
    

        // $response['code'] = 1;
        // $response['msg'] = "Success";
        // $response['data'] = $optionalItems;

        return json_encode($response);
    }

    public function getCurrentStockCount($id)
    {
        $query = ItemStock::where('item_id', $id)->where('status', 1)->pluck('qty');

        if(count($query) > 0){
            return $query[0];
        }else{
            return 0;
        }
    }

}
