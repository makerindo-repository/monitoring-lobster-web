<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityIdToIOTNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_o_t_nodes', function (Blueprint $table) {
            $table->foreignId('city_id')->after('id')->constrained('cities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_o_t_nodes', function (Blueprint $table) {
            $table->dropForeign('i_o_t_nodes_city_id_foreign');
            $table->dropColumn('city_id');
        });
    }
}
