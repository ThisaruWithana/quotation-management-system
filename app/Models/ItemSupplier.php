<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    protected $table = 'item_suppliers';

    protected $fillable = [
        'id','item_id','supplier_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
