<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Quotation extends Model
{
    use Sortable;
    protected $table = 'quotation';

    protected $fillable = [
        'id','customer_id', 'description','ref','price','margin', 'discount', 'item_cost', 'item_retail', 'vat',
        'total_vat','item_retail_margin','status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public $sortable = [ 'id', 'price'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id','id');
    }

}
