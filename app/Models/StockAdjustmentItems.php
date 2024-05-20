<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StockAdjustmentItems extends Model
{
    protected $table = 'stock_adjustment_items';

    protected $fillable = [
        'id', 'stock_adjustment_id' ,'item_id','qty', 'total_cost','item_cost', 'item_retail', 'stock_before',
         'total_retail', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }

    public function adjustment()
    {
        return $this->belongsTo('App\Models\StockAdjustment', 'stock_adjustment_id','id');
    }
}
