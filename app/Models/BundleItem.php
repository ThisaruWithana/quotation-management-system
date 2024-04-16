<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model
{
    protected $table = 'bundle_item';

    protected $fillable = [
        'id', 'bundle_id', 'item_id', 'actual_cost','retail','qty', 'total_cost', 'total_retail', 'order', 'display_report',
        'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'item_cost'
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
