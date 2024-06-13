<?php

namespace App\Imports;

use App\Models\DeliveryItems;
use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeliveryImport implements ToModel, WithStartRow
{
    private $delivery_id; 

    public function __construct($delivery_id)
    {
        $this->delivery_id = $delivery_id; 
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $qty = floatval($row[0]);
        $product_code = floatval($row[1]);

        $item_id = app('App\Http\Controllers\ItemController')->getItemIdByProductCode($product_code);

        $itemDetails = Item::where('id',$item_id)->first();
        $item_cost = $itemDetails['cost_price'];
        $item_retail = $itemDetails['retail_price'];

        $total_cost = $qty * $item_cost;
        $total_retail = $qty * $item_retail;
        $delivery_id = $this->delivery_id;

        return new DeliveryItems([
            'delivery_id'  => $delivery_id,
            'item_id'    => floatval($item_id),
            'item_cost'  => floatval($item_cost),
            'item_retail'  => floatval($item_retail),
            'qty'    => floatval($qty),
            'total_cost' => floatval($total_cost),
            'total_retail' => floatval($total_retail),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
    }
    
    public function startRow(): int
    {
        return 2;
    }
}
