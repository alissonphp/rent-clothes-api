<?php
$app->get('actives', 'BannerController@actives');
$app->group(['middleware' => 'jwt-auth'], function($app)
{
    $app->get('', 'BannerController@index');
    $app->post('', 'BannerController@store');
    $app->get('{id}', 'BannerController@show');
    $app->put('{id}', 'BannerController@update');
    $app->delete('{id}', 'BannerController@delete');
});