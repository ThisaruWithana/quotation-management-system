<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class OpfItems extends Model
{
    use Sortable;
    protected $table = 'opf_items';

    protected $fillable = [
        'id','opf_id', 'item_id', 'item_cost','retail','qty', 'total_cost', 'total_retail', 'status', 'created_at', 
        'updated_at', 'created_by', 'updated_by', 'actual_cost', 'actual_retail', 'type', 'order', 'on_order', 'order_qty'
    ];

    public $sortable = [ 'id'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function opf()
    {
        return $this->belongsTo('App\Models\Opf', 'opf_id','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
