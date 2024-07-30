<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Item;
use App\Models\Barcode;
use App\Models\ItemSupplier;
use App\Models\SubItem;
use App\Models\Department;
use App\Models\ItemStock;
use Illuminate\Support\Facades\Auth;

class ItemImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
           
            $product_code = $row['product_code'];
 
            $checkIfExist = Barcode::where('product_code', $row['product_code'])->first();

            if(!$checkIfExist){
                $case_size = $row['case_size'];
                $cost_price = $row['cost'];
                $retail_price = $row['retail'];
                $in_stock = $row['in_stock'];

                $getVatRate = Department::with('vat')->where('id', $row['department_id'])->first();
                $vat = 0;

                $vat_const = ($vat + 100)/100;
                $net_retail = $retail_price / $vat_const;
        
                $net_profit = $net_retail - $cost_price;

                if($net_retail != 0){
                    $margin = ($net_profit / $net_retail) * 100;
                }else{
                    $margin = 0;
                }

                $store = Item::create([
                    'department_id' => (int)$row['department_id'],
                    'sub_department_id' => (int)$row['sub_department_id'],
                    'location_id' => (int)$row['location_id'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'margin_type' => $row['margin_type'],
                    'item_size' => $row['item_size'],
                    'auto_order' => 1,
                    'cost_price' => $cost_price,
                    'retail_price' => $retail_price,
                    'margin' => round($margin, 2),
                    'min_stock' => $row['min_stock'],
                    'case_size' => $case_size,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                
                $suppliers = explode(',', $row['supplier_id']);
                $item_id = $store->id;
              
                $barcode = $item_id.$this->generateBarcode();

                $createBarcode = Barcode::create([
                    'product_code' => $product_code,
                    'barcode' => $barcode,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                $updateBarcode = Item::where('id', $item_id)->update([
                    'barcode_id' => $createBarcode->id,
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

                $checkExistingStock = ItemStock::where('item_id', $item_id)->where('status', 1)->first();

                if($checkExistingStock){

                    if($checkExistingStock['qty'] != $in_stock){
                        if($existingStock != 0){
                            $updateStock = ItemStock::where('item_id', $item_id)->update([
                                'status' => 0,
                                'updated_by' => Auth::user()->id
                            ]);  
                        } 
                      
                        $updateStock = ItemStock::create([
                            'item_id' => $item_id,
                            'qty' => $in_stock,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }else{
                    $updateStock = ItemStock::create([
                        'item_id' => $item_id,
                        'qty' => $in_stock,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                }


            }
        }
    }

    public  function generateBarcode($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $uniqueNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $uniqueNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $uniqueNumber;
    }
}
