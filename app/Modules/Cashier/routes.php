<?php

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('', 'CashierController@index');
});