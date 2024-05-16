<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barcode;
use App\Models\Item;
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

        // $data = [
        //     'title' => 'Barcode of '.$item['name'],
        //     'item' => $item['name'],
        //     'product_code' => $item['barcode']['product_code'],
        //     'barcode' =>$item['barcode']['barcode']
        // ];

        $pdf = PDF::loadView('print.barcode', $data);
        return $pdf->download('Barcode');
    }

}
