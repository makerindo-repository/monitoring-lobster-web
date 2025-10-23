<?php

use App\Models\Treshold;
use Illuminate\Database\Seeder;

class TresholdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namaSensor = [
            'ph' => [
                'value_max' => 8
            ],
            'cod'=> [
                'value_max'=> 50
            ],
            'nitrat'=>[
                'value_max'=>50
            ],
            'tss'=>[
                'value_max'=>40
            ],
            'debit_air'=>[
                'value_max'=>200
            ],
            'dissolver_oxygen'=>[
                'value_max'=>14
            ],
            'turbidity'=>[
                'value_max'=>50
            ],
            'salinity'=>[
                'value_max'=>20
            ],
            'tds'=>[
                'value_max'=>30
            ],
            'orp'=>[
                'value_max'=>1000
            ],
            'temperature_air'=>[
                'value_max'=>35
            ],
            'water_level_cm'=>[
                'value_max'=>100
            ],
            'water_level_persen'=>[
                'value_max'=>100
            ],
            'status_pompa'=>[
                'value_max'=> ''
            ]
        ];

        $iot_node_serial_number = 'NODE0001';

        foreach ($namaSensor as $variable => $tresholdData) {
            Treshold::create([
                'iot_node_serial_number' => $iot_node_serial_number,
                'variable' => $variable,
                'value_max' => $tresholdData['value_max']
            ]);
        }
    }
}
