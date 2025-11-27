<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKjaIdToLogPakans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_pakans', function (Blueprint $table) {
            $table->foreignId('kja_id')->after('petugas_id')->nullable()->constrained('kja', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_pakans', function (Blueprint $table) {
            $table->dropColumn('kja_id');
        });
    }
}
