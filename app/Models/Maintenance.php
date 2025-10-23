<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $guarded = [];

    public function iot_node() {
        return $this->belongsTo('App\Models\IOTNode');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
