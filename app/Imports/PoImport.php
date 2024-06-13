<?php

namespace App\Imports;

use App\Models\PoItems;
use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PoImport implements ToModel, WithStartRow
{
    
    private $po_id; 

    public function __construct($po_id)
    {
        $this->po_id = $po_id; 
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

        $total_cost = $qty * $item_cost;
        $po_id = $this->po_id;

        return new PoItems([
            'po_id'     => $po_id,
            'item_id'    => floatval($item_id),
            'item_cost'  => floatval($item_cost),
            'qty'    => floatval($qty),
            'total_cost' => floatval($total_cost),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
     
    }

    public function startRow(): int
    {
        return 2;
    }
}
