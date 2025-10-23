<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['code', 'name'];

    public function cities () {
        return $this->hasMany('App\Models\City');
    }
    public static function boot(){
        parent::boot();
        self::deleting(function($var){
            if ($var->cities->count() > 0){
            return false;
            }
        });
    }
}
