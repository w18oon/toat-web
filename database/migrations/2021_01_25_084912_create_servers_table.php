<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_toat')->create('ptw_servers', function (Blueprint $table) {
            $table->increments('server_id');
            $table->string('ip');
            $table->string('hostname');
            $table->string('description')->nullable();
            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_toat')->dropIfExists('ptw_servers');
    }
}
