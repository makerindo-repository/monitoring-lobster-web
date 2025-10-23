<?php

use App\User;
use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            SettingSeeder::class,
            SensorSeeder::class,
        ]);
        // Users
        User::create([
            'name' => 'Super User',
            'email' => 'superuser@gmail.com',
            'role' => 'su',
            'password' => \Hash::make('superuser@2022'),
            'picture' => 'Profiledefault.png'
        ]);
        User::create([
            'name' => 'Demo Petugas',
            'email' => 'petugas@gmail.com',
            'role' => 'petugas',
            'password' => \Hash::make('petugas@2022'),
            'picture' => 'Profiledefault.png'
        ]);
        User::create([
            'name' => 'Demo Direksi',
            'email' => 'direksi@gmail.com',
            'role' => 'direksi',
            'password' => \Hash::make('direksi@2022'),
            'picture' => 'Profiledefault.png'
        ]);


        // Regions & Cities
        foreach ($this->getRegions() as $region) {
            $model = Region::create([
                'name' => $region->provinsi
            ]);
            foreach ($region->kota as $kota) {
                City::create([
                    'region_id' => $model->id,
                    'name' => $kota
                ]);
            }
        }
    }

    public function getRegions () {
        return json_decode(file_get_contents('https://raw.githubusercontent.com/mtegarsantosa/json-nama-daerah-indonesia/master/regions.json'));
    }
}
