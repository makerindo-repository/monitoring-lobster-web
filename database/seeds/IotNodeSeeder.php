<?php

use App\Models\IOTNode;
use Illuminate\Database\Seeder;

class IotNodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IOTNode::create([
            'city_id' => 276,
            'edge_computing_id' => 1,
            'edge_computing_node' => 2,
            'serial_number' => 'NODE' . sprintf('%04d', 1),
            'user_id' => 2,
            'lat' => '-8.5124573',
            'lng' => '115.2541342',
            'activated_at' => now(),
            'activated_by' => 2
        ]);
    }
}
