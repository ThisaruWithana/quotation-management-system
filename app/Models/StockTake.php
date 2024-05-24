<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StockTake extends Model
{
    protected $table = 'stock_take';

    protected $fillable = [
        'id','total_cost_diff','comment', 'total_cost', 'total_retail', 'total_retail_diff', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }
}
