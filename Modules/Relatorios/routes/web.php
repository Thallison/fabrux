<?php

use Illuminate\Support\Facades\Route;
use Modules\Relatorios\Http\Controllers\RelatoriosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('relatorios', RelatoriosController::class)->names('relatorios');
});
