<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeolocationToIotNode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_o_t_nodes', function (Blueprint $table) {
            $table->string('lat')->after('ip_gateway')->nullable();
            $table->string('lng')->after('lat')->nullable();
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
                $table->dropColumn('latitude');
                $table->dropColumn('longitude');

        });
    }
}
