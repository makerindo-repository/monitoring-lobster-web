<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdgeComputing extends Model
{
    protected $guarded = [];

    public function activated_by () {
        return $this->belongsTo('App\User');
    }

    public function city () {
        return $this->belongsTo('App\Models\City');
    }

    public function iot_nodes () {
        return $this->hasMany('App\Models\IOTNode');
    }
    public function iot_node(): BelongsTo
    {
        return $this->belongsTo(IOTNode::class, 'edge_computing_id', 'id');
    }
    public static function boot(){
        parent::boot();
        self::deleting(function($var){
            if ($var->iot_nodes->count() > 0){
            return false;
            }
              // Hapus gambar sebelum data dihapus
        if ($var->picture) {
            $picture = public_path($var->picture);
            if (file_exists($picture)) unlink($picture);
        }

        if ($var->picture_genba) {
            $picture_genba = public_path($var->picture_genba);
            if (file_exists($picture_genba)) unlink($picture_genba);
        }
        });
    }
}
