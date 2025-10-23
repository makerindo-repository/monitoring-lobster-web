<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['code', 'region_id', 'name'];

    public function region () {
        return $this->belongsTo('App\Models\Region');
    }

    public function edge_computing() {
        return $this->belongsTo('App\Models\EdgeComputing', 'id', 'city_id');
    }
}
