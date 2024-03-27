<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'id','barcode_id', 'department_id','sub_department_id','vat_id','location_id', 'name', 'description', 'margin_type', 'item_size',
        'account_no','min_order_qty', 'min_order_value', 'surcharge', 'auto_order', 'order_days',
        'delivery_days','cost_price', 'retail_price', 'margin', 'min_stock', 'exclude_from_stock', 'image',
        'last_order_date','status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'case_size'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id','id');
    }

    public function subdepartment()
    {
        return $this->belongsTo('App\Models\SubDepartment', 'sub_department_id','id');
    }

    public function barcode()
    {
        return $this->belongsTo('App\Models\Barcode', 'barcode_id','id');
    }
    
    public function suppliers()
    {
        return $this->hasMany('App\Models\ItemSupplier', 'item_id', 'id')->where('status',1);
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id','id');
    }
    
}
