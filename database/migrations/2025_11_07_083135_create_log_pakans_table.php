<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPakansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pakans', function (Blueprint $table) {
            $table->id();
            $table->string('pemberian_ke');
            $table->string('jenis_pakan');
            $table->double('berat');
            $table->foreignId('petugas_id')->constrained('petugas');
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
        Schema::dropIfExists('log_pakans');
    }
}
