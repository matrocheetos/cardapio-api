<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'api',
    InitializeTenancyByDomain::class,
    //PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

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
            Route::get('/mesa/{nro_mesa}', 'listaNroMesa');
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

});
