<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';

    protected $fillable = [
        'id','name','vat_id','code', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

    public function vat()
    {
        return $this->belongsTo('App\Models\VAT', 'vat_id','id');
    }
}
