<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('cardapio')->group(function() {

    Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
        Route::get('/', 'lista');
        Route::get('/{id}', 'listaId');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/cria', 'cria');
            Route::put('/edita/{id}', 'edita');
            Route::delete('/deleta/{id}', 'deleta');
        });
    });

    Route::controller(MesaController::class)->prefix('mesa')->middleware('auth:sanctum')->group(function () {
        Route::get('/', 'lista');
        Route::get('/{comanda}', 'listaId');
        Route::get('/numero/{nro_mesa}', 'listaNroMesa');
        Route::post('/cria', 'cria');
        Route::put('/edita/{comanda}', 'edita');
        Route::delete('/deleta/{comanda}', 'deleta');
    });

    Route::controller(PedidoController::class)->prefix('pedido')->group(function () {
        Route::get('/', 'lista');
        Route::get('/{id}', 'listaId');
        Route::get('/comanda/{comanda}', 'listaComanda');
        Route::post('/cria', 'cria');

        Route::middleware('auth:sanctum')->group(function () {
            Route::put('/edita/{id}', 'edita');
            Route::delete('/deleta/{id}', 'deleta');
        });
    });

    Route::controller(ProdutoController::class)->prefix('produtos')->group(function () {
        Route::get('/', 'lista');
        Route::get('/{id}', 'listaId');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/cria', 'cria');
            Route::post('/edita/{id}', 'edita');
            Route::delete('/deleta/{id}', 'deleta');
        });
    });

});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::post('/cria', 'cria');
    Route::put('/edit', 'edita')->middleware('auth:sanctum');
});
