<?php

use Illuminate\Support\Facades\Route;
use Modules\Producao\Http\Controllers\ProducoesController;

Route::prefix('producao')->name('producao::')->group(function () {

    Route::middleware(['auth', 'verified','acl' ])->group(function () {
        Route::get('producoes/produtos/search', [ProducoesController::class, 'searchProdutos'])
            ->name('producoes.searchProdutos');

        Route::resource('producoes', ProducoesController::class)->names('producoes');
    });
});