<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Barcode;
use App\Models\ItemSupplier;
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

        return view('admin.item.create', compact('title', 'page', 'suppliers'));
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
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }
}
