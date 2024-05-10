<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    protected $table = 'deliveries';

    protected $fillable = [
        'id', 'po_id', 'supplier_id','total_cost', 'reference','total_retail', 'delivery_date', 'type',
         'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 
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
