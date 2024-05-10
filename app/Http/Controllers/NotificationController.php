<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use DB;

class NotificationController extends Controller
{
    public function store($user_id, $data_id, $message)
    {
        $response = array();

         try{
             DB::beginTransaction();

             $store = Notification::create([
                'user_id' => $user_id,
                'data_id' => $data_id,
                'message' => $message
            ]);
 
             if($store){
                DB::commit(); 
                $response['code'] = 1;
             }else{
                 DB::rollback();
                 $response['code'] = 0;
             }
             return json_encode($response);
         }catch(\Exception $e){
             DB::rollback();
             $response['code'] = 0;
             return json_encode($response);
        } 
    }

}
