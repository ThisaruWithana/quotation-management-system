<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PriceChangeLog extends Model
{
    protected $table = 'price_change_log';

    protected $fillable = [
        'id', 'item_id', 'old_cost_price','new_cost_price', 'old_retail_price','new_retail_price','status', 'created_at', 'updated_at', 'created_by', 'updated_by', 
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
