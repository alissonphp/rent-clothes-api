<?php

$app->post('','ClientController@store');
$app->get('cep/{cep}','ClientController@cep');

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'ClientController@index');
    $app->get('search/{term}', 'ClientController@search');
    $app->get('{id}', 'ClientController@show');
    $app->post('', 'ClientController@store');
    $app->put('{id}', 'ClientController@update');
    $app->delete('{id}', 'ClientController@delete');
});