<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PoItems extends Model
{
    use Sortable;
    protected $table = 'po_items';

    protected $fillable = [
        'id','po_id', 'item_id', 'item_cost','qty', 'total_cost', 'status', 'created_at', 
        'updated_at', 'created_by', 'updated_by'
    ];

    public $sortable = [ 'id'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function po()
    {
        return $this->belongsTo('App\Models\Po', 'opf_id','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
