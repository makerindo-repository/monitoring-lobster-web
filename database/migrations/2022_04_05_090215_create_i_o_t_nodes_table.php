<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIOTNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_o_t_nodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('edge_computing_id')->nullable();
            $table->bigInteger('edge_computing_node')->nullable();
            $table->string('serial_number')->unique();
            $table->string('ip')->nullable();
            $table->string('ip_gateway')->nullable();
            $table->text('picture')->nullable();
            $table->text('signature')->nullable();
            $table->text('picture_genba')->nullable();
            $table->datetime('installed_at')->nullable();
            $table->datetime('activated_at')->nullable();
            $table->unsignedBigInteger('activated_by')->nullable();
            $table->timestamps();

            $table->foreign('edge_computing_id')->references('id')->on('edge_computings')->onDelete('set null');
            $table->foreign('activated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i_o_t_nodes');
    }
}
