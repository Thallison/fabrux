<?php

use Illuminate\Support\Facades\Route;
use Modules\Procucao\Http\Controllers\ProcucaoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('procucaos', ProcucaoController::class)->names('procucao');
});
