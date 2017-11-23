<?php

$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->get('', 'UserController@index');
    $app->post('', 'UserController@store');
    $app->get('{id}', 'UserController@show');
    $app->put('{id}', 'UserController@update');
    $app->delete('{id}', 'UserController@delete');
});