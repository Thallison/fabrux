<?php

use Illuminate\Support\Facades\Route;
use Modules\Cadastros\Http\Controllers;

Route::prefix('cadastros')->name('cadastros::')->group(function () {

    Route::middleware(['auth', 'verified', 'acl'])->group(function () {
        Route::resource('setores', Controllers\SetoresController::class)
            ->parameters(['setores' => 'setor']);
        Route::resource('funcionarios', Controllers\FuncionariosController::class);
        Route::resource('produtos', Controllers\ProdutosController::class);
        Route::resource('clientes', Controllers\ClientesController::class);
    });
});
