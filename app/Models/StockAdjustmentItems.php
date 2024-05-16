<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StockAdjustmentItems extends Model
{
    protected $table = 'stock_adjustment_items';

    protected $fillable = [
        'id','item_id','qty', 'total_cost', 'total_retail', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
