<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Dashboardv2Controller extends Controller
{
    public function index(): View
    {
        $nodes = IOTNode::query()
            ->whereNotNull('activated_at')
            ->pluck('serial_number');

        $cities = City::with(['edge_computing'])->has('edge_computing')->get();

        $statistic = [
            'edge' => EdgeComputing::count(),
            'node' => IOTNode::count(),
            'node_active' => IOTNode::whereNotNull('activated_at')->count(),
            'city_count' => $cities->count(),
            'region_count' => count(array_unique($cities->pluck('region_id')->toArray())),
            'client' =>  Client::count(),
        ];

        return view('pages.dashboardv2', compact('nodes', 'statistic'));
    }
}
