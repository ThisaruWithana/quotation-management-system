<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    protected $fillable = [
        'id','user_id','type', 'created_at', 'updated_at', 'message', 'read_at', 'data_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }

}
