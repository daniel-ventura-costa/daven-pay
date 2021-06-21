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
    return $router->app->version();
});

$router->group(['prefix' => '/api/v1', 'middleware' => 'auth'], function () use ($router) {

    // Users
    $router->get('/users', 'UserController@all');

    // Wallets
    $router->get('/wallet', 'WalletController@read');
    $router->post('/wallet', 'WalletController@create');

    // Transactions
    $router->post('/transaction', 'TransactionController@transaction');
});

$router->post('/api/v1/login', [
    'middleware' => 'cors',
    'uses' => 'TokenController@login'
]);
