<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class QuotationItem extends Model
{
    use Sortable;
    protected $table = 'quotation_item';

    protected $fillable = [
        'id','quotation_id', 'item_id', 'item_cost','retail','qty', 'total_cost', 'total_retail', 'order', 'display_report', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public $sortable = [ 'id', 'description'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation', 'quotation_id','id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id','id');
    }
}
