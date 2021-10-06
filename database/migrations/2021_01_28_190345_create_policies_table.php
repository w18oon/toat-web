<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_policies', function (Blueprint $table) {
            $table->increments('policy_id');
            // $table->string('org_id');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->string('type'); // EXPENSE, MILEAGE
            $table->string('mileage_unit')->nullable(); // FOR TYPE MILEAGE
            $table->boolean('active')->default(true);

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_policies');
    }
}
