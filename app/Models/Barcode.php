<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'barcode';

    protected $fillable = [
        'id','product_code','barcode','description','status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
