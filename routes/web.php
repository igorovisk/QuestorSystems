<?php

use App\Http\Controllers\BancoController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoCobrancaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes - Cria todas as rotas CRUD automaticamente
// GET    /clientes           -> index()
// GET    /clientes/create    -> create()
// POST   /clientes           -> store()
// GET    /clientes/{id}      -> show()
// GET    /clientes/{id}/edit -> edit()
// PUT    /clientes/{id}      -> update()
// DELETE /clientes/{id}      -> destroy()
Route::resource('clientes', ClienteController::class);

// Rotas para Bancos
Route::resource('bancos', BancoController::class);

// Rotas para Boletos
Route::resource('boletos', BoletoController::class);

// Rotas para Serviços de Cobrança
Route::get('/servicos-cobranca/create', [ServicoCobrancaController::class, 'create'])->name('servicos-cobranca.create');
Route::post('/servicos-cobranca', [ServicoCobrancaController::class, 'store'])->name('servicos-cobranca.store');
Route::get('/servicos-cobranca', [ServicoCobrancaController::class, 'index'])->name('servicos-cobranca.index');
