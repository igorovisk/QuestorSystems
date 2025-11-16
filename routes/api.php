<?php

use App\Http\Controllers\BancoController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoCobrancaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui estão as rotas da API. Todas as rotas aqui são prefixadas com /api
| e retornam JSON automaticamente.
|
*/

// Rotas de Clientes
Route::apiResource('clientes', ClienteController::class)->names([
    'index' => 'api.clientes.index',
    'store' => 'api.clientes.store',
    'show' => 'api.clientes.show',
    'update' => 'api.clientes.update',
    'destroy' => 'api.clientes.destroy',
]);

// Rotas de Bancos
Route::apiResource('bancos', BancoController::class)->names([
    'index' => 'api.bancos.index',
    'store' => 'api.bancos.store',
    'show' => 'api.bancos.show',
    'update' => 'api.bancos.update',
    'destroy' => 'api.bancos.destroy',
]);

// Rotas de Boletos
Route::apiResource('boletos', BoletoController::class)->names([
    'index' => 'api.boletos.index',
    'store' => 'api.boletos.store',
    'show' => 'api.boletos.show',
    'update' => 'api.boletos.update',
    'destroy' => 'api.boletos.destroy',
]);

// Rotas de Serviços de Cobrança
Route::prefix('servicos-cobranca')->group(function () {
    Route::post('/', [ServicoCobrancaController::class, 'store'])->name('api.servicos-cobranca.store');
    Route::get('/', [ServicoCobrancaController::class, 'index'])->name('api.servicos-cobranca.index');
    Route::get('/{id}', [ServicoCobrancaController::class, 'show'])->name('api.servicos-cobranca.show');
});
