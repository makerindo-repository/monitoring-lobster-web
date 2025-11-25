<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJumlahLobsterToKjas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kja', function (Blueprint $table) {
            $table->integer('jumlah_lobster')->after('kondisi')->nullable()->default(0);
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
            $table->dropColumn('jumlah_lobster');
        });
    }
}
