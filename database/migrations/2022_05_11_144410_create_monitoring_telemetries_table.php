<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringTelemetriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_telemetries', function (Blueprint $table) {
            $table->id();
            $table->string('device_timestamp')->nullable();
            $table->string('id_perangkat')->nullable();
            $table->decimal('latitude', 20, 15)->nullable();
            $table->decimal('longitude', 20, 15)->nullable();
            $table->decimal('altitude', 20, 15)->nullable();
            $table->decimal('pitch', 20, 15)->nullable();
            $table->decimal('roll', 20, 15)->nullable();
            $table->decimal('yaw', 20, 15)->nullable();
            $table->float('suhu')->nullable();
            $table->float('kelembapan')->nullable();
            $table->float('pressure')->nullable();
            $table->float('suhu_air')->nullable();
            $table->float('dissolved_oxygen')->nullable();
            $table->float('ph')->nullable();
            $table->float('turbidity')->nullable();
            $table->float('salinity')->nullable();
            $table->float('arus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_telemetries');
    }
}
