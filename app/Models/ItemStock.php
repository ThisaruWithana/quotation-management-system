<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    protected $table = 'item_stock';

    protected $fillable = [
        'id', 'item_id', 'qty','status', 'created_at', 'updated_at', 'created_by', 'updated_by', 
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id','id');
    }
}
