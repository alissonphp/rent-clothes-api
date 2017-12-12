<?php

$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->get('', 'UserController@index');
    $app->get('role/{roleId}', 'UserController@getUserRole');
    $app->post('', 'UserController@store');
    $app->get('{id}', 'UserController@show');
    $app->put('{id}', 'UserController@update');
    $app->delete('{id}', 'UserController@delete');
    $app->get('current/seller/goals', 'UserController@currentGoals');
});