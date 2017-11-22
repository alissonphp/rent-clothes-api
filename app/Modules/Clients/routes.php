<?php

$app->post('','ClientController@store');
$app->get('cep/{cep}','ClientController@cep');

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'ClientController@index');
    $app->delete('{id}', 'ClientController@delete');
});