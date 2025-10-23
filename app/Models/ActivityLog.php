<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id','status','waktu'];


    public function user() {
        return $this->belongsTo('App\User');
    }

}
