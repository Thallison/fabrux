<?php

use Illuminate\Support\Facades\Route;
use Modules\Seguranca\Http\Controllers\SegurancaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('segurancas', SegurancaController::class)->names('seguranca');
});
