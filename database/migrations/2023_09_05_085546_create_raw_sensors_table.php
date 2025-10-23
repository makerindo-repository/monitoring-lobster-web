<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('iot_node_serial_number')->nullable();
            $table->float('temperature_node')->default(0);
            $table->float('temperature_edge')->default(0);
            $table->float('humidity_node')->default(0);
            $table->float('humidity_edge')->default(0);
            $table->float('dissolver_oxygen')->default(0);
            $table->float('turbidity')->default(0);
            $table->float('salinity')->default(0);
            $table->float('cod')->default(0);
            $table->float('ph')->default(0);
            $table->float('orp')->default(0);
            $table->float('tds')->default(0);
            $table->float('nitrat')->default(0);
            $table->float('temperature_air')->default(0);
            $table->float('tss')->default(0);
            $table->float('water_level_cm')->default(0);
            $table->float('water_level_persen')->default(0);
            $table->float('debit_air',8,2)->default(0);
            $table->unsignedTinyInteger('status_pompa')->default(0);
            $table->timestamps();

            $table->foreign('iot_node_serial_number')->references('serial_number')->on('i_o_t_nodes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_sensors');
    }
}
