<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTresholdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tresholds', function (Blueprint $table) {
            $table->id();
            $table->string('iot_node_serial_number')->nullable();
            $table->string('variable')->nullable();
            $table->double('value_min',8,2)->default(0);
            $table->double('value_max',8,2)->default(0);
            $table->double('value',8,2)->default(0);
            $table->string('rules')->nullable();
            $table->timestamps();
            $table->foreign('variable')->references('namaSensor')->on('sensors')->nullOnDelete();
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
        Schema::dropIfExists('tresholds');
    }
}
