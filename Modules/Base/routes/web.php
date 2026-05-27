<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Controllers\CepController;

/*Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('bases', BaseController::class)->names('base');
});
*/
/*Route::prefix('base')->name('base::')->group(function() {
    Route::resource('base', BaseController::class)->names('base');
});
*/

// Rotas públicas para buscar CEP
Route::get('/api/cep/buscar', [CepController::class, 'buscar'])->name('cep.buscar');
