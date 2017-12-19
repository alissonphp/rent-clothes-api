<?php

$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->get('', 'UserController@index');
    $app->get('role/{roleId}', 'UserController@getUserRole');
    $app->post('', 'UserController@store');
    $app->get('show/{id}', 'UserController@show');
    $app->put('{id}', 'UserController@update');
    $app->delete('{id}', 'UserController@delete');
    $app->get('active', 'UserController@current');
    $app->get('current/seller/goals', 'UserController@currentGoals');
    $app->post('profile/avatar/upload', 'UserController@profileUpdate');
});