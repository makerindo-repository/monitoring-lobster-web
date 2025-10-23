<?php

namespace App\Models;

use App\Models\EdgeComputing;
use App\Models\MonitoringTelemetry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IOTNode extends Model
{
    protected $guarded = [];

    public function user () {
        return $this->belongsTo('App\User', 'activated_by');
    }

    // public function edge_computing () {
    //     return $this->belongsTo('App\Models\EdgeComputing');
    // }

    public function city () {
        return $this->belongsTo('App\Models\City');
    }

    public function monitoring_telemetries() {
        return $this->hasMany('App\Models\MonitoringTelemetry', 'iot_node_serial_number', 'serial_number');
    }

    public function monitoring_telemetri() {
        return $this->hasOne('App\Models\MonitoringTelemetry', 'iot_node_serial_number', 'serial_number')->orderByDesc('created_at');
    }
    public function treshold() {
        return $this->hasMany('App\Models\Treshold', 'iot_node_serial_number', 'serial_number');
    }
    public static function boot(){
        parent::boot();
        self::deleting(function($var){
            if ($var->treshold->count() > 0){
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
    /**
     * Get the sensor associated with the IOTNode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sensor(): HasOne
    {
        return $this->hasOne(MonitoringTelemetry::class, 'iot_node_serial_number', 'serial_number')->orderByDesc('created_at');
    }
    public function edge_computing(): HasOne
    {
        return $this->hasOne(EdgeComputing::class, 'id', 'edge_computing_id');
    }

}
