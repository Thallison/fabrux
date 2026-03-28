<?php

use Illuminate\Support\Facades\Route;
use Modules\Relatorios\Http\Controllers\RelatoriosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('relatorios', RelatoriosController::class)->names('relatorios');
});
