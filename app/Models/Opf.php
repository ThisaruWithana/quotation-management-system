<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Opf extends Model
{
    protected $table = 'opf';

    protected $fillable = [
        'id','quotation_id','cost','margin', 'symbol_group', 'installation_date', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function created_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by','id');
    }

}
