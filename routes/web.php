<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return [
        'lumen' => $router->app->version(),
        'ip' => $_SERVER['SERVER_ADDR']
    ];
});

$router->group(['prefix' => '/api/v1', 'middleware' => ['auth', 'cors']], function () use ($router) {
    $router->post('/transaction', 'TransactionController@transaction');
});

$router->post('/api/v1/login', ['uses' => 'TokenController@login']);
