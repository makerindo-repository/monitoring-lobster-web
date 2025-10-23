<?php

namespace App\Models;

use App\Models\Treshold;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model

{
    protected $fillable = ['namaSensor'];

    public function treshold() {
        return $this->hasMany('App\Models\Treshold', 'variable', 'namaSensor');
    }
    public static function boot(){
        parent::boot();
        self::deleting(function($var){
            if ($var->treshold->count() > 0){
            return false;
            }
        });
    }
}
