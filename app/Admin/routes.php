<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('/department', 'DepartmentController');
    $router->resource('/enterprise', 'EnterpriseController');

    $router->resource('projects', ProjectController::class);


    Route::get('/rabbitPush', 'RabbitPushController@send')->name('rabbit.send');
    Route::get('/rabbitPull', 'RabbitPushController@receive')->name('rabbit.receive');
    Route::get('/queue', 'RabbitPushController@queue')->name('rabbit.queue');
});
