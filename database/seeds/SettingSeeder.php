<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Setting::first()) {
            Setting::create([
                'pt_name'=> 'IPB',
                'name' => 'WQMS',
                'description' => 'WQMS',
                'version' => '1.0',
                'copyright' => 'IPB',
                'logo' => 'images/ipb-logo.png'
            ]);
        }
    }
}
