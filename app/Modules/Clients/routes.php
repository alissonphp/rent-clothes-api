<?php

$app->post('','ClientController@store');

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'ClientController@index');
    $app->delete('{id}', 'ClientController@delete');
});