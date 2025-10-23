<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor;
use App\Models\MonitoringTelemetry;

class Treshold extends Model
{
    protected $guarded = [];
    public function sensors() {
        return $this->belongsTo('App\Models\Sensor', 'namaSensor', 'variable');
    }
    public function monitoring_telemetries()
    {
        return $this->belongsTo(MonitoringTelemetry::class, 'iot_node_serial_number', 'iot_node_serial_number');
    }
}
