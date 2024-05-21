<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StockTakeItems extends Model
{
    protected $table = 'stock_take_items';

    protected $fillable = [
        'id', 'stock_take_id' ,'item_id','book_stock','physical_stock', 'diff', 'total_cost', 'total_cost_diff',
         'item_cost', 'item_retail', 'total_retail',
         'total_retail_diff', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
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
