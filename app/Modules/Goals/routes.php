<?php

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'GoalsController@index');
    $app->get('{id}', 'GoalsController@show');
    $app->post('', 'GoalsController@store');
    $app->put('{id}', 'GoalsController@update');
    $app->delete('{id}', 'GoalsController@delete');
});