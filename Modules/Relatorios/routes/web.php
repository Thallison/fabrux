<?php

use Illuminate\Support\Facades\Route;
use Modules\Relatorios\Http\Controllers\RelatoriosController;

Route::prefix('relatorios')->name('relatorios::')->group(function () {

    //Rotas autenticadas mas e precisam de permissão
    Route::middleware(['auth', 'verified', 'acl'])->group(function () {
        Route::get('producao-diaria', [RelatoriosController::class, 'productionDaily'])
            ->name('producao.diaria');

        Route::get('produtividade-funcionario', [RelatoriosController::class, 'productivityEmployee'])
            ->name('produtividade.funcionario');

        Route::get('producao-produto', [RelatoriosController::class, 'productionProduct'])
            ->name('producao.produto');

        Route::get('comparativo', [RelatoriosController::class, 'comparison'])
            ->name('comparativo');

        Route::get('projecao', [RelatoriosController::class, 'projection'])
            ->name('projecao');

        Route::resource('relatorios', RelatoriosController::class)->names('relatorios');
    });
});
