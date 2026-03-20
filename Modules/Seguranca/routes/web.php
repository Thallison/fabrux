<?php

use Illuminate\Support\Facades\Route;
use Modules\Seguranca\Http\Controllers;

Route::prefix('seguranca')->name('seguranca::')->group(function () {

    Route::middleware(['auth', 'verified','acl' ])->group(function () {
        Route::resource('sistemas', Controllers\SistemasController::class);
        Route::resource('modulos', Controllers\ModulosController::class);
        Route::resource('funcionalidades', Controllers\FuncionalidadesController::class);
        Route::resource('privilegios', Controllers\PrivilegiosController::class);
        Route::resource('papeis', Controllers\PapeisController::class);
        Route::resource('usuarios', Controllers\UsuariosController::class);

        Route::prefix('privilegios')->name('privilegios.')->group( function(){
            Route::delete('/destroydep/{dependencia}', [Controllers\PrivilegiosController::class, 'destroyDep'])->name('destroydep');
        });

        Route::prefix('usuarios')->name('usuarios.')->group( function(){
            Route::post('/validalogin',  [Controllers\UsuariosController::class, 'validaLogin'])->name('validaLogin');
            Route::post('/atualizaSenha', [Controllers\UsuariosController::class, 'atualizaSenha'])->name('atualizaSenha');
        });
    });

    Route::get('/configUsuario', [Controllers\UsuariosController::class, 'configuracaoShow'])->name('configUsuario');
});