<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
//\Cache::forget('ROUTES:API');

if (\Cache::has('ROUTES:API')) {
    $ROUTES = \Cache::get('ROUTES:API');
} else {
    $ROUTES = [];

    try {
        $ROUTES = \DB::table('app_route')->where('prefix', 'api')->get();
        \Cache::forever('ROUTES:API', $ROUTES);
    } catch (\Exception $e) {
        \Log::debug(json_encode(['debug'=>'Set Route', 'error'=>$e]));
    }
}
//var_dump($ROUTES);

/* Main API Route */
$router->group(['prefix'=>'api'], function () use ($router, $ROUTES) {
    foreach ($ROUTES as $config) {
        $routing = [
            'uses'			    => $config->uses,
            'middleware'	=> $config->middleware != '' ? $config->middleware : null,
        ];
        $router->{$config->method}($config->route, $routing);
    }
});

//var_dump($router->getRoutes());
