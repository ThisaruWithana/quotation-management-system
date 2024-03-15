<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VAT;
use DB;
use Auth;

class VatController extends Controller
{
    public function index()
    {
        $title = 'VAT';
        $data = VAT::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.vat.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Insert VAT Value';
        $page = 'add';
        return view('admin.vat.create', compact('title', 'page'));
    }

    public function store(Request $request)
    {
            try{
                DB::beginTransaction();

                $request->validate([
                    'name' => 'required',
                    'rate' => 'required',
                ]);

                // Disable existing VAT values
                $update = DB::table('vat')
                ->where('status', 1)
                ->update([
                    'status' => 0,
                    'created_by' => Auth::user()->id
                ]);

                // Add new VAT value
                $query = VAT::create([
                    'name' => $request->input('name'),
                    'value' => $request->input('rate'),
                    'created_by' =>  Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                DB::commit();

                $msg = 'VAT created successfully.';
                return redirect()->route('admin.vat.index')->with('success',$msg);

            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } 
    }
}
