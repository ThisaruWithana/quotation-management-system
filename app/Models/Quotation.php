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
        'id','customer_id', 'description','ref','price','margin', 'discount', 'vat_rate',
        'vat_amt','final_price','status', 'created_at', 'updated_at', 'created_by', 'updated_by'
        ,'total_cost', 'total_retail', 'quotation_vat', 'quotation_margin', 'retail_print_option'
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
