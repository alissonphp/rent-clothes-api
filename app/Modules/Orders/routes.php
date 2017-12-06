<?php

$app->post('','OrderController@store');

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'OrderController@index');
    $app->get('sellers', 'OrderController@sellers');
    $app->post('', 'OrderController@store');
    $app->get('{id}', 'OrderController@show');
    $app->put('{id}', 'OrderController@update');
    $app->delete('{id}', 'OrderController@delete');

    $app->get('status/{id}/{status}', 'OrderController@status');
    $app->get('items-situation/{id}/{situation}', 'OrderController@itemSituation');
    $app->post('payment', 'OrderController@pay');
});