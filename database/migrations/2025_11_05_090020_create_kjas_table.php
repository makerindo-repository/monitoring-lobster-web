<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kja', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kja');
            $table->decimal('latitude', 20, 15);
            $table->decimal('longitude', 20, 15);
            $table->double('dimensi');
            $table->string('kondisi');
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
        Schema::dropIfExists('kja');
    }
}
