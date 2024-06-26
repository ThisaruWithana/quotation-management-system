<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barcode;
use App\Models\Item;
use App\Models\Po;
use App\Models\PoItems;
use DB;
use Auth;
use PDF;

class ReportController extends Controller
{
    public function barcode()
    {
        $title = 'Print Labels';
        $items = Item::orderBy('name','ASC')->get();
        return view('admin.reports.barcode', compact('items', 'title'));
    }

    public function printLabels(Request $request)
    {
        $items = $request->input('items');

        $itemList = Item::with('barcode')->whereIn('id', $items)->get();
        
        $data = [
            'date' => date('d-m-Y'),
            'itemList' => $itemList
        ]; 

        $pdf = PDF::loadView('print.barcode', $data);
        return $pdf->stream('Barcode', array("Attachment" => false));
    }

    public function itemOrderHistory(Request $request)
    {
        $pageSize;

        if (!isset($request->pagesize)) {
            $new = 10;
        }else{
            $new = $request->pagesize;
        }

        $pageSize = $new;
        $items = '';
        $itemList = $request->input('items');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $title = 'Item Order History';

        if($request->query('form_action') === 'search'){

            
            $data = PoItems::query()->with('po', 'item')->where('status', 1)->orderBy('created_at','DESC');

            if(!is_null($itemList)) {
                $data->where('item_id', $itemList);
            }

            if(!is_null($from_date) && !is_null($to_date)) {
                $data->whereBetween('created_at', [$from_date, $to_date]);
            }
        }else{
            $data = PoItems::query()->with('po', 'item')->where('status', 1)->where('item_id', $items)
            ->orderBy('created_at','DESC');
        }
                
        $listData = $data->paginate($pageSize);  
        $items = Item::orderBy('name','ASC')->get();

        return view('admin.reports.item-order-history', compact('items', 'title', 'pageSize', 'listData'));
    }

}
