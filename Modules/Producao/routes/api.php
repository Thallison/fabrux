<?php

use Illuminate\Support\Facades\Route;
use Modules\Producao\Http\Controllers\ProducaoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('producaos', ProducaoController::class)->names('producao');
});
