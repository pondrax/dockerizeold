<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoute extends Migration
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
            $table->string('uses');//->unique();
            $table->string('prefix');
            $table->string('middleware');
            $table->string('description')->nullable();
            $table->boolean('deletable')->default(1);
            $table->boolean('hidden')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });

        $csv = 'menu_id,method,route,uses,prefix,middleware,description,deletable,hidden
1,GET,app/dashboard/{read},App\DashboardController@read,api,,,0,0
1,GET,app/user/notification,App\UserController@notification,api,,,0,1
1,GET,app/user/profile,App\UserController@profile,api,,,0,1
2,GET,app/menu/{read},App\MenuController@read,api,,,0,0
2,POST,app/menu,App\MenuController@create,api,,,0,0
2,PUT,app/menu/{id},App\MenuController@update,api,,,0,0
2,DELETE,app/menu/{id},App\MenuController@delete,api,,,0,0
3,GET,app/route/testing,App\RouteController@testing,api,,,0,0
3,GET,app/route/{read},App\RouteController@read,api,,,0,0
3,POST,app/route,App\RouteController@create,api,,,0,0
3,POST,app/route/generator,App\RouteController@generator,api,,,0,0
3,PUT,app/route/{id},App\RouteController@update,api,,,0,0
3,DELETE,app/route/{id},App\RouteController@delete,api,,,0,0
3,GET,app/access/{read},App\AccessController@delete,api,,,0,0
3,POST,app/access,App\AccessController@create,api,,,0,0
3,PUT,app/access/{id},App\AccessController@update,api,,,0,0
3,DELETE,app/access/{id},App\AccessController@delete,api,,,0,0
4,GET,app/user/{read},App\UserController@read,api,,,0,0
4,POST,app/user,App\UserController@create,api,,,0,0
4,PUT,app/user/{id},App\UserController@update,api,,,0,0
4,DELETE,app/user/{id},App\UserController@read,api,,,0,0
5,GET,app/role/{read},App\RoleController@read,api,,,0,0
5,POST,app/role,App\RoleController@create,api,,,0,0
5,PUT,app/role/{id},App\RoleController@update,api,,,0,0
5,DELETE,app/role/{id},App\RoleController@read,api,,,0,0
6,GET,app/config/{read},App\ConfigController@read,api,,,0,0
6,POST,app/config,App\ConfigController@create,api,,,0,0
6,PUT,app/config/{id},App\ConfigController@update,api,,,0,0
6,DELETE,app/config/{id},App\ConfigController@read,api,,,0,0
6,GET,app/configvalue/{read},App\ConfigvalueController@read,api,,,0,0
6,POST,app/configvalue,App\ConfigvalueController@create,api,,,0,0
6,PUT,app/configvalue/{id},App\ConfigvalueController@update,api,,,0,0
6,DELETE,app/configvalue/{id},App\ConfigvalueController@read,api,,,0,0
7,GET,app/media/{read},App\MediaController@read,api,,,0,0
7,POST,app/media,App\MediaController@create,api,,,0,0
7,PUT,app/media/{id},App\MediaController@update,api,,,0,0
7,DELETE,app/media/{id},App\MediaController@read,api,,,0,0
7,GET,app/queue/{read},App\QueueController@read,api,,,0,0
7,POST,app/queue,App\QueueController@create,api,,,0,0
7,PUT,app/queue/{id},App\QueueController@update,api,,,0,0
7,DELETE,app/queue/{id},App\QueueController@read,api,,,0,0
7,GET,app/cache/{read},App\CacheController@read,api,,,0,0
7,POST,app/cache,App\CacheController@create,api,,,0,0
7,PUT,app/cache/{id},App\CacheController@update,api,,,0,0
7,DELETE,app/cache/{id},App\CacheController@read,api,,,0,0
8,GET,app/logaudit/{read},App\LogauditController@read,api,,,0,0
8,DELETE,app/logaudit/{id},App\LogauditController@read,api,,,0,0
8,GET,app/logsystem/{read},App\LogsystemController@read,api,,,0,0
8,DELETE,app/logsystem/{id},App\LogsystemController@read,api,,,0,0';

        DB::table('app_route')->insert(csvToArray($csv));
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