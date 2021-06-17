<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_route', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('menu_id')->constrained('app_menu');
            $table->string('method');
            $table->string('route');
            $table->string('uses'); //->unique();
            $table->string('prefix');
            $table->string('middleware');
            $table->string('data')->nullable();
            $table->boolean('deletable')->default(1);
            $table->boolean('hidden')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_route');
    }
}
