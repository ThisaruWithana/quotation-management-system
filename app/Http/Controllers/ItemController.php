<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Item;
use DB;
use Auth;

class ItemController extends Controller
{
    public function index()
    {
        $title = 'Item Maintainance';
        $data = Item::with('created_user')->orderBy('id','DESC')->get();
        return view('admin.item.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Add New Item';
        $page = 'add';
        return view('admin.item.create', compact('title', 'page'));
    }
    
    public function edit($id)
    {
        $title = 'Edit Item';
        $page = 'edit';
        $data = Item::where('id',decrypt($id))->first();
        return view('admin.item.create',compact('data', 'title', 'page'));
    }
}
