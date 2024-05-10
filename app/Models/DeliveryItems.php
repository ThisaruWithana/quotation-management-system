<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DeliveryItems extends Model
{
    protected $table = 'delivery_items';

    protected $fillable = [
        'id','delivery_id', 'item_id', 'item_cost','qty', 'total_cost', 'item_retail', 'total_retail', 'status', 'created_at', 
        'updated_at', 'created_by', 'updated_by'
    ];

    public $sortable = [ 'id'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\Deliveries', 'delivery_id','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
