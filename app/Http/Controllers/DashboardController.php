<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use App\Models\City;
use App\Models\Maintenance;
use App\Models\Kja;
use App\Models\LogPakan;
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

    public function index()
    {
        $payload = [];
        $cities = City::with(['edge_computing'])->has('edge_computing')->get();
        // $payload['nodes'] = IOTNode::query()
        //     ->whereNotNull('activated_at')
        //     ->pluck('serial_number');

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

        // $payload['region_node_active']   = IOTNode::with(['edge_computing.city.region'])->whereNotNull('activated_at')->has('monitoring_telemetries')->get();
        $payload['registration_history'] = IOTNode::with(['user', 'city'])->whereNotNull('activated_at')->get();
        $payload['maintenance_history']  = Maintenance::with('iot_node')->latest()->limit(5)->get();
        // dd($payload['maintenance_history']);

        // Data Cuaca
        $payload['weather'] = null;

        // ambil adm4 dari DB (kode desa)
        $weatherSetting = WeatherSetting::first();
        if (!$weatherSetting || !$weatherSetting->village_code) {
            return view($this->view, $payload);
        }

        $adm4 = $this->formatAdm4($weatherSetting->village_code);

        // hit BMKG API
        $response = Http::get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}");

        if ($response->successful()) {
            $json = $response->json();
            $desa = $json['lokasi']['desa'];
            $kotkab = $json['lokasi']['kotkab'];
            $provinsi = $json['lokasi']['provinsi'];

            // pastikan ada data
            if (!empty($json['data'][0]['cuaca'])) {
                $now = Carbon::now('Asia/Jakarta');
                $nearest = null;
                $minDiff = PHP_INT_MAX;

                foreach ($json['data'][0]['cuaca'] as $slot) {
                    foreach ($slot as $forecast) {
                        if (empty($forecast['local_datetime'])) {
                            continue;
                        }

                        $dt = Carbon::parse($forecast['local_datetime'], 'Asia/Jakarta');
                        $diff = abs($now->diffInMinutes($dt));

                        if ($diff < $minDiff) {
                            $minDiff = $diff;
                            $nearest = $forecast;
                        }
                    }
                }

                if ($nearest) {
                    $weather = [
                        'temp'       => $nearest['t'] ?? '--',
                        'humidity'   => $nearest['hu'] ?? '--',
                        'wind'       => $nearest['ws'] ?? '--',
                        'rain'       => $nearest['tp'] ?? '--',
                        'desc'       => $nearest['weather_desc'] ?? '--',
                        'icon_url'   => $nearest['image'] ?? null,
                        'local_time' => $nearest['local_datetime'] ?? null,
                        'desa' => $desa,
                        'kotkab' => $kotkab,
                        'provinsi' => $provinsi,
                    ];
                }
            }
        }

        $payload['weather'] = $weather;

        $payload['logPakan'] = LogPakan::latest()->paginate(10);

        return view($this->view, $payload);
    }

    // Format kode desa sesuai adm4 BMKG
    private function formatAdm4(string $villageCode): string
    {
        $code = str_pad($villageCode, 10, '0', STR_PAD_LEFT);

        $adm1 = substr($code, 0, 2);
        $adm2 = substr($code, 2, 2);
        $adm3 = substr($code, 4, 2);
        $adm4 = substr($code, 6, 4);

        return "{$adm1}.{$adm2}.{$adm3}.{$adm4}";
    }
}
