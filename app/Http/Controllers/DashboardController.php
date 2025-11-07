<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use App\Models\City;
use App\Models\Maintenance;
use App\Models\Kja;

class DashboardController extends Controller
{
    public function __construct () {
        $this->view = 'pages.dashboardv2';
    }

    public function index () {
        $payload = [];
        $cities = City::with(['edge_computing'])->has('edge_computing')->get();
        $payload['nodes'] = IOTNode::query()
            ->whereNotNull('activated_at')
            ->pluck('serial_number');

        $payload['cameras'] = Camera::where('status', true)->get();

        $payload['statistic'] = [
            'edge' => EdgeComputing::count(),
            'node' => IOTNode::count(),
            'node_active' => IOTNode::whereNotNull('activated_at')->count(),
            'city_count' => $cities->count(),
            'region_count' => count(array_unique($cities->pluck('region_id')->toArray())),
            'kja' =>  Kja::count(),
            'camera_active' => Camera::where('status', true)->count(),
        ];

        $payload['region_node_active']   = IOTNode::with(['edge_computing.city.region'])->whereNotNull('activated_at')->has('monitoring_telemetries')->get();
        $payload['registration_history'] = IOTNode::with(['user', 'city'])->whereNotNull('activated_at')->get();
        $payload['maintenance_history']  = Maintenance::with('iot_node')->latest()->limit(5)->get();
        // dd($payload['maintenance_history']);
        return view($this->view, $payload);
    }
}
