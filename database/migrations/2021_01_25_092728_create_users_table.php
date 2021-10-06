<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_toat')->create('ptw_users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('username')->unique();
            $table->string('department_code')->nullable();
            $table->string('password');
            $table->datetime('email_verified_at')->nullable();
            $table->rememberToken();

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
        Schema::connection('oracle_toat')->dropIfExists('ptw_users');
    }
}
