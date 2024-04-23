<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class QuotationDescription extends Model
{
    use Sortable;
    protected $table = 'quotation_description';

    protected $fillable = [
        'id','description', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public $sortable = [ 'id', 'description'];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
