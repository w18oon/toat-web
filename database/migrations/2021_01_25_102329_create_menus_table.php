<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_toat')->create('ptw_menus', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->string('menu_code')->nullable();
            $table->string('module_code')->nullable();

            // $table->string('menu_first_level')->nullable();
            // $table->string('menu_second_level')->nullable();
            // $table->string('menu_third_level');

            $table->string('menu_title', 255)->default(null);
            $table->integer('parent_id')->default(0);
            $table->string('sort_order')->default(0);
            $table->string('url')->default(null);

            $table->string('permission_code');

            // $table->string('text_display');
            $table->string('route_name')->nullable();

            $table->integer('server_id');
            $table->boolean('active')->default(true);
            $table->string('program_code')->nullable();

            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by');
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
        Schema::connection('oracle_toat')->dropIfExists('ptw_menus');
    }
}
