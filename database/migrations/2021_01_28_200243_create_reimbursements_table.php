<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReimbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_reimbursements', function (Blueprint $table) {
            $table->increments('reimbursement_id');
            $table->string('org_id');
            $table->string('document_no');
            $table->integer('user_id');
            $table->string('currency_id');
            $table->string('purpose', 2000)->nullable();
            $table->string('status');
            $table->integer('next_approver_id')->nullable();
            $table->boolean('over_budget')->nullable();
            $table->boolean('exceed_policy')->nullable();

            $table->date('request_date')->nullable();
            $table->integer('preparer_id')->nullable();
            $table->integer('finance_approver_id')->nullable();
            $table->bigInteger('vendor_id')->nullable();
            $table->bigInteger('vendor_site_id')->nullable();
            $table->integer('next_approver_pos_id')->nullable();
            $table->integer('approval_id')->nullable();

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_reimbursements');
    }
}
