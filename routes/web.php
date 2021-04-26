<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "Application: apiAuth<br>Version: " . $router->app->version();
});

/**
 * free routes
 */
$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('create', 'UserController@create');
    $router->post('login', 'AuthenticateController@authenticate');
    $router->post('reset-password', 'ForgotPasswordController@resetPassword');
});

/**
 * authenticated routes
 */
$router->group(['middleware' => ['jwtAuth']], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/update-password', 'UserController@updatePassword');
    });
});