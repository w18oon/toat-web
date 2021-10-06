<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_policy_rates', function (Blueprint $table) {
            $table->increments('policy_rate_id');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->integer('policy_id');
            $table->string('location_id')->nullable();
            $table->string('position_po_level')->nullable();
            $table->boolean('unlimit')->default(false);
            $table->decimal('rate',20,8)->nullable();
            $table->string('currency_id');
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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_policy_rates');
    }
}
