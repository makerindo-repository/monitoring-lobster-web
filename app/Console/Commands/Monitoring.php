<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use App\Models\IOTNode;
use App\Models\Treshold;
use App\Models\RawSensor;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use App\Models\MonitoringTelemetry;
use App\Events\MonitoringTelemetryEvent;

class Monitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live:Monitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitoring';

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
    echo "init...";
    $topic_sub = "WQ01";
    $mqtt = MQTT::connection('mosquitto');
    $nodes = IOTNode::query()->pluck('serial_number')->toArray();
    $sensors = Sensor::all();
    $tresholds = []; // Inisialisasi variabel treshold

    // Mendapatkan nilai treshold untuk setiap sensor sekali
    foreach ($sensors as $sensor) {
        $variableName = $sensor->namaSensor;
        $treshold = Treshold::where('variable', $variableName)->first();
        if ($treshold) {
            $tresholds[$variableName] = $treshold; // Menyimpan nilai treshold ke dalam wadah
        }
    }

    foreach ($nodes as $node) {
        $mqtt->subscribe($topic_sub, function (String $topic, String $message) use ($mqtt, $node, $tresholds) {
            print('Subscribe ke topic');
            print($message);
            $data = $message;

            // Parsing pesan MQTT
            $pattern = '/^(\w{4}),([-\d.]+),([-\d.]+),([-?\d.]+),([-\d.]+),([-\d.]+),([-\d.]+),([-\d.]+),([-\d.]+),(\w+),#$/';
            if (preg_match($pattern, $data, $matches)) {
                print('Sensor');
                // Mendapatkan nilai dari pesan MQTT
                $wqcms = $matches[1];
                $temperature = $matches[2];
                $humidity = $matches[3];
                $orp = $matches[4];
                $do = $matches[5];
                $ph = $matches[6];
                $air_temperature = $matches[7];
                $water_level_cm = $matches[8];
                $nitrat = $matches[9];
                $status_pompa = $matches[10];

                // Pengukuran kalibrasi menggunakan nilai treshold yang sesuai untuk setiap sensor
                $calibratedOrp = $tresholds['orp'] ? $this->performCalibration($orp, $tresholds['orp']->value_min, $tresholds['orp']->value_max, $tresholds['orp']->value) : null;
                $calibratedDo = $tresholds['dissolver_oxygen'] ? $this->performCalibration($do, $tresholds['dissolver_oxygen']->value_min, $tresholds['dissolver_oxygen']->value_max, $tresholds['dissolver_oxygen']->value) : null;
                $calibratedph = $tresholds['ph'] ? $this->performCalibration($ph, $tresholds['ph']->value_min, $tresholds['ph']->value_max, $tresholds['ph']->value) : null;
                $calibratedTemp = $tresholds['temperature_air'] ? $this->performCalibration($air_temperature, $tresholds['temperature_air']->value_min, $tresholds['temperature_air']->value_max, $tresholds['temperature_air']->value) : null;
                $calibratedCm = $tresholds['water_level_cm'] ? $this->performCalibration($water_level_cm, $tresholds['water_level_cm']->value_min, $tresholds['water_level_cm']->value_max, $tresholds['water_level_cm']->value) : null;
                $calibratedNitrat = $tresholds['nitrat'] ? $this->performCalibration($nitrat, $tresholds['nitrat']->value_min, $tresholds['nitrat']->value_max, $tresholds['nitrat']->value) : null;

                // Simpan data ke dalam database sesuai dengan hasil kalibrasi
                MonitoringTelemetry::create([
                    'iot_node_serial_number' => $node,
                    'temperature_node' => $temperature,
                    'humidity_node' => $humidity,
                    'orp' => $calibratedOrp,
                    'ph' => $calibratedph,
                    'dissolver_oxygen' => $calibratedDo,
                    'temperature_air' => $temperature,
                    'water_level_cm' => $calibratedCm,
                    'nitrat' => $calibratedNitrat,
                    'status_pompa' => $status_pompa,
                ]);

                // Simpan data mentah ke dalam database
                RawSensor::create([
                    'iot_node_serial_number' => $node,
                    'temperature_node' => $temperature,
                    'humidity_node' => $humidity,
                    'orp' => $orp,
                    'ph' => $ph,
                    'dissolver_oxygen' => $do,
                    'temperature_air' => $temperature,
                    'water_level_cm' => $water_level_cm,
                    'nitrat' => $nitrat,
                    'status_pompa' => $status_pompa,
                ]);
            } else {
                echo "Format data tidak sesuai.";
            }
            broadcast(new MonitoringTelemetryEvent($node, $message, ['message' => $message]));
        }, 1);
    }
    $mqtt->loop(true);
}
private function performCalibration($sensorValue, $minValue, $maxValue, $offset)
{
    // Lakukan normalisasi terlebih dahulu
    $normalizedValue = $this->normalizeValue($sensorValue, $minValue, $maxValue);

    // Proses kalibrasi
    $calibratedValue = $normalizedValue + $offset;

    // Pastikan nilai kalibrasi tetap dalam rentang yang ditentukan
    $calibratedValue = $this->clampValue($calibratedValue, $minValue, $maxValue);

    return $calibratedValue;
}

// Fungsi untuk normalisasi nilai ke dalam rentang tertentu
private function normalizeValue($value, $min, $max)
{
    return max($min, min($value, $max));
}

// Fungsi untuk membatasi nilai dalam rentang tertentu
private function clampValue($value, $min, $max)
{
    return $value < $min ? $min : ($value > $max ? $max : $value);
}



    }
