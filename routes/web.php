<?php

use Illuminate\Support\Facades\Route;
use Modules\Producao\Http\Controllers\ProducoesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ProducoesController::class, 'dashboard']);
});