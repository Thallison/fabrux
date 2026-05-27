<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Controllers\CepController;

/*Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('bases', BaseController::class)->names('base');
});
*/

// Rota pública para buscar CEP
Route::get('/cep/buscar', [CepController::class, 'buscar'])->name('cep.buscar');
