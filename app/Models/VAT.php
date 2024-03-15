<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VAT extends Model
{
    protected $table = 'vat';

    protected $fillable = [
        'id','name','status', 'created_at', 'updated_at', 'value', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }
}
