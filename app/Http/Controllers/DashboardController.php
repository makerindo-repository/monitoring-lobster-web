<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use App\Models\Maintenance;
use App\Models\Kja;
use App\Models\LogPakan;
use App\Models\MonitoringTelemetry;
use App\Models\WeatherSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public $view;

    public function __construct()
    {
        $this->view = 'pages.dashboardv2';
    }

    public function index(Request $request)
    {
        $payload = [];

        $latestTelemetry = MonitoringTelemetry::latest()->first();
        $weather = WeatherSetting::first();

        $payload['latest_telemetry'] = $latestTelemetry;
        $payload['cameras'] = Camera::where('status', true)->get();
        $payload['statistic'] = [
            'edge' => EdgeComputing::count(),
            'node' => IOTNode::count(),
            'node_active' => IOTNode::whereNotNull('activated_at')->count(),
            'kja' =>  Kja::count(),
            'camera_active' => Camera::where('status', true)->count(),
            'lobster_all' => Kja::sum('jumlah_lobster'),
        ];
        $payload['registration_history'] = IOTNode::with(['user', 'city'])->whereNotNull('activated_at')->get();
        $payload['maintenance_history']  = Maintenance::with('iot_node')->latest()->limit(5)->get();
        $payload['weather'] = $weather;
        // $payload['region_node_active']   = IOTNode::with(['edge_computing.city.region'])->whereNotNull('activated_at')->has('monitoring_telemetries')->get();
        // dd($payload['maintenance_history']);
        $video = Camera::query();

        if ($request->filled('camera')) {
            $video->where('id_kamera', $request->camera);
        } else {
            // default kamera
            $video->where('id_kamera', 'CAM001');
        }

        $videoResult = $video->first();

        $payload['video'] = $videoResult;

        $payload['latitude'] = Kja::where('id', $videoResult->kja_id)->first()->latitude;
        $payload['longitude'] = Kja::where('id', $videoResult->kja_id)->first()->longitude;

        $payload['kjas'] = Kja::get();

        $payload['logPakan'] = LogPakan::latest()->paginate(10);

        return view($this->view, $payload);
    }
}
