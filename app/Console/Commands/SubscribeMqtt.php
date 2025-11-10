<?php

namespace App\Console\Commands;

use App\Models\MonitoringTelemetry;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $mqtt = MQTT::connection();

        $mqtt->subscribe('esp32/sensor/pgdn', function (string $topic, string $message) {
            try {
                $data = json_decode($message, true);

                MonitoringTelemetry::create([
                    'device_timestamp' => $data['timestamp'] ?? 0,
                    'id_perangkat'     => $data['ID_Devices'] ?? 0,
                    'latitude'         => $data['Latitude'] ?? 0,
                    'longitude'        => $data['Longitude'] ?? 0,
                    'altitude'         => $data['Altitude'] ?? 0,
                    'pitch'            => $data['Pitch'] ?? 0,
                    'roll'             => $data['Roll'] ?? 0,
                    'yaw'              => $data['Yaw'] ?? 0,
                    'suhu'             => $data['Suhu'] ?? 0,
                    'kelembapan'       => $data['Humidity'] ?? 0,
                    'pressure'         => $data['Pressure'] ?? 0,
                    'suhu_air'         => $data['Suhu_air'] ?? 0,
                    'dissolved_oxygen' => $data['DO'] ?? 0,
                    'ph'               => $data['PH'] ?? 0,
                    'turbidity'        => $data['Turbidity'] ?? 0,
                    'salinity'         => $data['Salinity'] ?? 0,
                    'arus'             => $data['Arus'] ?? 0,
                ]);

                $this->info("Berhasil simpan data ke DB!");
            } catch (\Exception $e) {
                $this->error("Gagal simpan data: " . $e->getMessage());
            }
        });

        $mqtt->loop();
    }
}
