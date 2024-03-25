<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VAT;
use App\Models\Department;
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

    public function edit($id)
    {
        $title = 'Edit VAT';
        $data = VAT::where('id',decrypt($id))->first();
        return view('admin.vat.edit',compact('data', 'title'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'rate' => ['required', 'string']
        ]); 

         // Disable existing VAT values
        $update = DB::table('vat')
            ->where('id', $id)
            ->update([
                'status' => 0,
                'created_by' => Auth::user()->id
        ]);
        
        $query = VAT::create([
            'name' => $request->input('name'),
            'value' => $request->input('rate'),
            'created_by' =>  Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
        
        $update = DB::table('department')
            ->where('vat_id', $id)
            ->update([
                'vat_id' => $query->id,
                'updated_by' => Auth::user()->id
        ]);

        return redirect()->route('admin.vat.index')->with('success','VAT updated successfully.');
    }

    public function barcode()
    {
        return view('barcode');
    }
}
