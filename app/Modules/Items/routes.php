<?php

$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->group(['prefix' => 'item'], function($app){

        $app->get('', 'ItemController@index');
        $app->post('', 'ItemController@store');
        $app->get('{id}', 'ItemController@show');
        $app->put('{id}', 'ItemController@update');
        $app->delete('{id}', 'ItemController@delete');
        $app->post('images/upload/{id}', 'ItemController@imageUpload');

    });

    $app->group(['prefix' => 'category'], function($app){

        $app->get('', 'CategoryController@index');
        $app->post('', 'CategoryController@store');
        $app->get('{id}', 'CategoryController@show');
        $app->put('{id}', 'CategoryController@update');
        $app->delete('{id}', 'CategoryController@delete');

    });

    $app->group(['prefix' => 'size'], function ($app){
       $app->post('', 'ItemSizeController@store');
       $app->get('{id}', 'ItemSizeController@show');
       $app->put('{id}', 'ItemSizeController@update');
       $app->delete('{id}', 'ItemSizeController@delete');
    });
});