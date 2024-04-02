<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    protected $table = 'sub_items';

    protected $fillable = [
        'id','parent_id','sub_item_id', 'is_mandatory', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function parentitem()
    {
        return $this->belongsTo('App\Models\Item', 'parent_id','id');
    }

    public function subitem()
    {
        return $this->belongsTo('App\Models\Item', 'sub_item_id','id');
    }
}
