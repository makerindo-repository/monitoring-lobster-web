<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdgeComputingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edge_computings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('serial_number')->unique();
            $table->string('memory')->nullable();
            $table->string('processor_clock_speed')->nullable();
            $table->string('os')->nullable();
            $table->string('framework')->nullable();
            $table->string('power_supply')->nullable();
            $table->string('voltage')->nullable();
            $table->string('ip')->nullable();
            $table->string('ip_gateway')->nullable();
            $table->integer('maximum_iot')->default(50);
            $table->text('picture')->nullable();
            $table->text('signature')->nullable();
            $table->text('picture_genba')->nullable();
            $table->datetime('installed_at')->nullable();
            $table->datetime('activated_at')->nullable();
            $table->unsignedBigInteger('activated_by')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('activated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edge_computings');
    }
}
