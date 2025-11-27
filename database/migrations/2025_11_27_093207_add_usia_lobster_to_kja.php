<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsiaLobsterToKja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kja', function (Blueprint $table) {
            $table->integer('usia_lobster')->nullable();
            $table->timestamp('timestamp_input_usia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kja', function (Blueprint $table) {
            $table->dropColumn('usia_lobster');
            $table->dropColumn('timestamp_input_usia');
        });
    }
}
