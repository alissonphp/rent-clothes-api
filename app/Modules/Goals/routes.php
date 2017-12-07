<?php

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'ConfigController@index');
    $app->post('', 'ConfigController@store');
    $app->delete('{id}', 'ConfigController@delete');
    $app->put('{id}', 'ConfigController@update');
});