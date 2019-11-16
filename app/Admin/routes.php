<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('department', 'DepartmentController');
    $router->resource('projects', ProjectController::class);
    $router->resource('enterprise', 'EnterpriseController');
    //部门项目
    $router->resource('department/{departmentId}/projects', DepartmentProjectController::class);

    //项目企业
    $router->resource('department/projects/{projectId}/enterprise', ProjectEnterpriseController::class);
    $router->get('department/projects/{projectId}/selectEnterprise', 'ProjectEnterpriseController@selectEnterprise')->name('selectEnterprise');

    //$router->get('departmentProjects/{id}', 'ProjectController@departmentproject');

    Route::get('/rabbitPush', 'RabbitPushController@send')->name('rabbit.send');
    Route::get('/rabbitPull', 'RabbitPushController@receive')->name('rabbit.receive');
    Route::get('/queue', 'RabbitPushController@queue')->name('rabbit.queue');

    $router->resource('smstemplates', SmsTemplateController::class);
    $router->resource('emailtemplates', EmailTemplateController::class);

    $router->resource('smslogs', SmsLogsController::class);
    $router->resource('emaillogs', EmailLogController::class);
});
