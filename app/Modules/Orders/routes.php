<?php

$app->post('','OrderController@store');

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'OrderController@index');
    $app->get('{id}', 'OrderController@show');
    $app->put('{id}', 'OrderController@update');
    $app->delete('{id}', 'OrderController@delete');
});