<?php

use Illuminate\Support\Facades\Route;
use Modules\Producao\Http\Controllers\ProducoesController;

Route::prefix('producao')->name('producao::')->group(function () {

    //Rotas autenticadas mas e precisam de permissão
    Route::middleware(['auth', 'verified','acl' ])->group(function () {
        Route::get('producoes/produtos/search', [ProducoesController::class, 'searchProdutos'])
            ->name('producoes.searchProdutos');

        Route::resource('producoes', ProducoesController::class)->names('producoes');
    });

    //Rotas autenticadas mas não precisa de permissão
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboard', [ProducoesController::class, 'dashboard'])->name('producoes.dashboard');
    });

});