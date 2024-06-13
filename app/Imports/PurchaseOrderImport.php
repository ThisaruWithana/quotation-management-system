<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PurchaseOrderImport implements ToCollection, WithHeadingRow, WithStartRow
{
    private $po_id; 

    public function __construct($po_id)
    {
        $this->po_id = $po_id; 
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            var_dump($row['msp']); die();
            $qty = floatval($row['qty']);
            $product_code = floatval($row['msp']);

            $customer = Department::where('code', $row['code'])->first();
            if($customer){

                $customer->update([
                    'vat_id' => 2,
                    'name' => $row['name'],
                    'updated_by' => Auth::user()->id
                ]);

            }else{

                Department::create([
                    'vat_id' => 2,
                    'name' => $row['name'],
                    'code' => $row['code'],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);
            }

        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
