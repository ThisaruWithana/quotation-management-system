<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $table = 'po';

    protected $fillable = [
        'id','supplier_id','cost', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by',
         'order_date', 'expected_date', 'type'
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
