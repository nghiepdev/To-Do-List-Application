<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

/**
 * FOR APPLICATION
 */
$router->group(['middleware' => 'web'], function ($router) {
    $router->get('/', function () {
        return view('welcome');
    });

    $router->auth();

    $router->get('/todos', 'TodoController@index');
});

/**
 * FOR API
 */
$router->group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'Api'], function ($router) {
    $router->resource('todo', 'TodoController', [
        'only' => ['index', 'store', 'update', 'destroy'],
    ]);
});
