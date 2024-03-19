<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'id','department_id','sub_department_id','vat_id','location_id', 'name', 'description', 'margin_type', 'item_size',
        'account_no','min_order_qty', 'min_order_value', 'surcharge', 'auto_order', 'order_days',
        'delivery_days','cost_price', 'retail_price', 'margin', 'min_stock', 'exclude_from_stock', 'image',
        'last_order_date','status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
