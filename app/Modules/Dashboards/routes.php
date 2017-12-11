<?php

$app->group(['middleware' => 'jwt-auth'], function($app) {
    $app->get('admin', 'DashboardsController@admin');
});