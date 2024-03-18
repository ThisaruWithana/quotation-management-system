<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = 'sub_department';

    protected $fillable = [
        'id','name','department_id','code', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function departments()
    {
        return $this->belongsTo('App\Models\Department', 'department_id','id');
    }
}
