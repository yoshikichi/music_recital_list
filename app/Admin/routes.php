<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();
Route::resource('admin/auth/users', \App\Admin\Controllers\CustomUserController::class)->middleware(config('admin.route.middleware'));
Route::resource('admin/auth/setting', \App\Admin\Controllers\CustomAuthController::class)->middleware(config('admin.route.middleware'));

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('recitals', RecitalController::class);
    $router->resource('players', PlayerController::class);
    $router->resource('musictitles', MusictitleController::class);
    $router->resource('recital_programs', RecitalProgramController::class);
    $router->resource('recital_programs_musics', RecitalProgramMusicController::class);
    $router->resource('recital_programs_options', RecitalProgramOptionController::class);
    $router->get('auth/setting', 'CustomAuthController@getSetting');
    $router->put('auth/setting', 'CustomAuthController@putSetting');
	$router->resource('Adminmail/recitalmail', RecitalMailController::class);
	//$router->get('Adminmail/recitalmail/mailto/{id}', 'RecitalMailController@mailto');

});

