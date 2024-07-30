<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            
            // $checkIfExist = Customer::where('email', $row['email'])->first();

            // if(!$checkIfExist){

                $store = Customer::create([
                    'name' => $row['name'],
                    'contact_person' => $row['contact_person'],
                    'address' => $row['address'],
                    'postal_code' => $row['postcode'],
                    'tel' => $row['telephone'],
                    'mobile' => $row['mobile'],
                    'email' => $row['email'],
                    'symbol_group' => $row['symbol_group'],
                    'type' => $row['type'],
                    'created_by' =>  Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                $customer_id = $store->id;
                $customer_type = $row['type'];
                $code;
                $type;

                $length = strlen((string)$customer_id);

                if($customer_type === 'Prospective' || $customer_type === 'prospective'){
                    $type = 'P';
                }else if($customer_type === 'Accepted' || $customer_type === 'accepted'){
                    $type = 'A';
                }else{
                    $type = 'I';
                }

                if($length == 1){
                    $code =  $type.'000'.$customer_id;
                }else if($length == 2){
                    $code =  $type.'00'.$customer_id;
                }else if($length == 3){
                    $code =  $type.'0'.$customer_id;
                }else{
                    $code =  $type.$customer_id;
                }

                $update = Customer::where('id', $customer_id)->update([
                    'code' => $code,
                    'updated_by' => Auth::user()->id
                ]);
            // }
        }
    }
}
