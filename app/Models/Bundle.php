<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $table = 'bundle';

    protected $fillable = [
        'id','name','remark', 'total_cost', 'total_retail', 'bundle_cost', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
