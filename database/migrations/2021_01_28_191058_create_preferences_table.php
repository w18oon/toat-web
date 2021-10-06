<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_preferences', function (Blueprint $table) {
            $table->increments('preference_id');
            // $table->string('org_id');
            $table->string('code');
            $table->string('data_type'); // varchar,number,date,json
            $table->string('data_value')->nullable();
            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->dropIfExists('ptw_preferences');
    }
}
