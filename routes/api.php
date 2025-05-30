<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;

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

    Route::controller(MesaController::class)->prefix('mesa')->group(function () {
        Route::get('/', 'lista');
        Route::get('/{id}', 'listaId');
        Route::get('/{nro_mesa}', 'listaNroMesa');
        Route::post('/cria', 'cria');
        Route::put('/edita/{id}', 'edita');
        Route::delete('/deleta/{id}', 'deleta');
    });

    Route::controller(PedidoController::class)->prefix('pedido')->group(function () {
        Route::get('/pedidos', 'lista');
        Route::get('/pedidos/{id}', 'listaId');
        Route::get('/pedidos/comanda/{comanda}', 'listaComanda');
        Route::post('/pedidos', 'cria');
        Route::put('/pedidos/{id}', 'edita');
        Route::delete('/pedidos/{id}', 'deleta');
    });

    Route::controller(ProdutoController::class)->prefix('produtos')->group(function () {
        Route::get('/produtos', 'lista');
        Route::get('/produtos/{id}', 'listaId');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/produtos', 'cria');
            Route::put('/produtos/{id}', 'edita');
            Route::delete('/produtos/{id}', 'deleta');
        });
    });

});
