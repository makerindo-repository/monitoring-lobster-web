<?php

namespace App\Models;

use App\Models\IOTNode;
use App\Models\Treshold;
use Illuminate\Database\Eloquent\Model;

class MonitoringTelemetry extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function iot_node()
    {
        return $this->belongsTo(IOTNode::class, 'iot_node_serial_number', 'serial_number');
    }
    public function treshold()
    {
        return $this->hasMany(Treshold::class, 'iot_node_serial_number', 'iot_node_serial_number');
    }

}
