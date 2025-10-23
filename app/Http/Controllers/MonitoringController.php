<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\IOTNode;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Facades\MQTT;
use Adrianorosa\GeoLocation\GeoLocation;
use App\Events\MonitoringTelemetryEvent;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\EdgeComputingResource;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->view = 'pages.monitoring.';
    }

    public function index()
    {
        $regions = Region::pluck('name', 'id')->toArray();
        $data    = IOTNode::with(['edge_computing', 'city.region'])
            ->get();

        $ip = env('APP_ENV') === 'production' ? request()->ip() : '140.213.16.23';

        // dd($ip);

        $details = GeoLocation::lookup($ip);

        // dd(EdgeComputingResource::class);

        $centerPoint = [
            'lat' => $details->getLatitude(),
            'lng' => $details->getLongitude()
        ];

        $currentLocation = Region::query()
            ->whereHas('cities', function (Builder $query) use ($details) {
                return $query->where('name', 'like', '%' . $details->getCity() . '%');
            })
            ->first(['id', 'name']);

        return view($this->view . 'list', compact('regions', 'data', 'currentLocation', 'centerPoint'));
    }

    public function live(Request $request)
    {
        $payload['node'] = IOTNode::where('serial_number', $request->n)->whereNotNull('activated_at')->firstOrFail();

        return view($this->view . 'live', $payload);
    }
}
