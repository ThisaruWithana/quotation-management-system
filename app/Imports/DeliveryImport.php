<?php

namespace App\Imports;

use App\Models\DeliveryItems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeliveryImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DeliveryItems([
            //
        ]);
    }
    
    public function startRow(): int
    {
        return 2;
    }
}
