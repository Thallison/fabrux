<?php

use Illuminate\Support\Facades\Route;
use Modules\Procucao\Http\Controllers\ProcucaoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('procucaos', ProcucaoController::class)->names('procucao');
});
