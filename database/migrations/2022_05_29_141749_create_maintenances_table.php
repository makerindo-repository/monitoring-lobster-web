<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iot_node_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description');
            $table->text('picture')->nullable();
            $table->text('signature')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->foreign('iot_node_id')->references('id')->on('i_o_t_nodes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('maintenances');
    }
}
