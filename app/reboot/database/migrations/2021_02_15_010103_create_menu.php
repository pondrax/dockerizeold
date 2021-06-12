<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu');
            $table->string('icon');
            $table->integer('num');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });

        $csv = 'menu,icon,num
Dashboard -> Dashboard,el-icon-menu,1
Developer -> Menu,e-icon-set-up,99
Developer -> Route,e-icon-set-up,98
Management -> User,e-icon-setting,81
Management -> Role,e-icon-setting,82
Management -> Config,e-icon-setting,83
Management -> Manage,e-icon-setting,84
Management -> Logs,e-icon-setting,85
Data -> Data,e-icon-s-data,11';

        DB::table('app_menu')->insert(csvToArray($csv));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_menu');
    }
}
