<?php

$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->get('category', 'CategoryController@index');
    $app->post('category', 'CategoryController@store');
    $app->get('category/{id}', 'CategoryController@show');
    $app->put('category/{id}', 'CategoryController@update');
    $app->delete('category/{id}', 'CategoryController@delete');
});