<?php

namespace App\Imports;

use App\Models\PoItems;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PoImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $qty = floatval($row[0]);
        $item_cost = floatval($row[0]);

        $total_cost = $qty * $item_cost;

        return new PoItems([
            
            'po_id'     => floatval($row[0]),
            'item_id'    => floatval($row[0]),
            'item_cost'    => $item_cost,
            'qty'    => $qty,
            'total_cost'    => $total_cost,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
