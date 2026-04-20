<?php


use Illuminate\Support\Facades\Route;
use Modules\Producao\Http\Controllers\ProducoesController;


// Rota livre para landing page
Route::get('/landing', function () {
    return view('landing');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ProducoesController::class, 'dashboard']);
});