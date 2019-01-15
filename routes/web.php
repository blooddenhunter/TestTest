<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;

/* @var Router $router */
$router->group(['middleware' => ['guest']], function (Router $router) {
    $router->get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    $router->post('login', [LoginController::class, 'login']);
});

$router->group(['middleware' => ['auth']], function (Router $router) {
    $router->get('/', [ClientController::class, 'index'])
        ->name('home');

    $router->match(['GET', 'POST'], 'logout', [LoginController::class, 'logout'])
        ->name('logout');

    $router->resource('client', ClientController::class)->only([
        'create', 'store', 'edit', 'update'
    ]);

    $router->get('client/locked/{clientId}', [ClientController::class, 'locked'])
        ->name('client.locked');

    $router->get('transaction/create/{clientId}', [TransactionController::class, 'create'])
        ->name('transaction.create');

    $router->post('transaction/store', [TransactionController::class, 'store'])
        ->name('transaction.store');

    $router->get('transaction/report', [TransactionController::class, 'report'])
        ->name('transaction.report');

    $router->get('transaction/{clientId}', [TransactionController::class, 'getByClientId'])
        ->name('transaction.client');
});


