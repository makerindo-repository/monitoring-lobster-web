<?php

use App\Models\EdgeComputing;
use Illuminate\Database\Seeder;

class EdgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $key = 0;
            EdgeComputing::create([
                'city_id' => 274,
                'serial_number' => 'ED22' . str_pad($key++,3, "0", STR_PAD_LEFT),
                'memory' => '8GB',
                'processor_clock_speed' => '2',
                'os' => 'OS',
                'framework' => 'framework',
                'power_supply' => 'AC',
                'voltage' => '2v',
                'ip' => '0.0.0.0',
                'ip_gateway' => '0.0.0.0',
                'lat' => '-8.434067',
                'lng' => '115.6146341',
                'maximum_iot' => 1,
                'activated_at' => now(),
                'activated_by' => 2
            ]);

    }
}
