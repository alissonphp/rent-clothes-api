<?php

//$app->get('login/{provider}',   'LoginController@redirectToProvider');
//$app->get('login/{provider}/callback', 'LoginController@handleProviderCallback');
$app->post('login/credentials', 'LoginController@authenticate');
$app->post('remember-password', 'LoginController@remember');
$app->post('reset-password', 'LoginController@resetPassword');
$app->post('check-token', 'LoginController@checkToken');
