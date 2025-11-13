<?php

namespace App\Console\Commands;

use App\Models\WeatherSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchBmkg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:bmkg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data cuaca dari API BMKG';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ambil adm4 dari DB (kode desa)
        $weatherSetting = WeatherSetting::first();
        if (!$weatherSetting || !$weatherSetting->village_code) {
            Log::warning('Pengaturan data cuaca tidak ditemukan!');
            return;
        }

        $adm4 = $this->formatAdm4($weatherSetting->village_code);

        // hit BMKG API
        $response = Http::get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}");

        if ($response->successful()) {
            $json = $response->json();
            $desa = $json['lokasi']['desa'];
            $kecamatan = $json['lokasi']['kecamatan'];
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
                    $weatherSetting->desa = $desa;
                    $weatherSetting->kecamatan = $kecamatan;
                    $weatherSetting->kabupaten_kota = $kotkab;
                    $weatherSetting->provinsi = $provinsi;
                    $weatherSetting->temperature = $nearest['t'] ?? '--';
                    $weatherSetting->humidity = $nearest['hu'] ?? '--';
                    $weatherSetting->wind_speed = $nearest['ws'] ?? '--';
                    $weatherSetting->rainfall = $nearest['tp'] ?? '--';
                    $weatherSetting->image = $nearest['image'] ?? null;
                    $weatherSetting->description = $nearest['weather_desc'] ?? '--';
                    $weatherSetting->save();
                    Log::info("Data cuaca berhasil diperbarui!");
                }
            }
        }
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
