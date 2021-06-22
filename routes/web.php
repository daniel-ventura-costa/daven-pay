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
    return [
        'lumen' => $router->app->version(),
        'ip' => $_SERVER['SERVER_ADDR']
    ];
});

$router->group(['prefix' => '/api/v1', 'middleware' => ['auth', 'cors']], function () use ($router) {
    // Users
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@create');
    $router->get('/users/{id}', 'UserController@show');
    $router->put('/users/{id}', 'UserController@update');
    $router->delete('/users/{id}', 'UserController@delete');

    // Transactions
    $router->post('/transaction', 'TransactionController@transaction');
});

$router->post('/api/v1/login', ['middleware' => 'cors', 'uses' => 'TokenController@login']);
