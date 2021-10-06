<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_toat')->create('ptw_permissions', function (Blueprint $table) {
            $table->increments('permission_id');
            $table->string('group')->nullable();
            $table->integer('menu_id');
            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });

        Schema::connection('oracle_toat')->create('ptw_permission_user', function (Blueprint $table) {;
            $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('permission_id')->unsigned();
            // $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);

            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_toat')->dropIfExists('ptw_permissions');
        Schema::connection('oracle_toat')->dropIfExists('ptw_permission_user');
    }
}
