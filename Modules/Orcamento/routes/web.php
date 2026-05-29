<?php

use Illuminate\Support\Facades\Route;
use Modules\Orcamento\Http\Controllers\OrcamentosController;

Route::prefix('orcamento')->name('orcamento::')->group(function () {
    Route::middleware(['auth', 'verified', 'acl'])->group(function () {
        Route::get('orcamentos', [OrcamentosController::class, 'index'])->name('orcamentos.index');
        Route::get('orcamentos/create', [OrcamentosController::class, 'create'])->name('orcamentos.create');
        Route::post('orcamentos', [OrcamentosController::class, 'store'])->name('orcamentos.store');
        Route::get('orcamentos/{id}', [OrcamentosController::class, 'show'])->name('orcamentos.show');
        Route::delete('orcamentos/{id}', [OrcamentosController::class, 'destroy'])->name('orcamentos.destroy');

        Route::get('orcamentos/{id}/pdf', [OrcamentosController::class, 'previewPdf'])->name('orcamentos.preview-pdf');
        Route::get('orcamentos/{id}/pdf/download', [OrcamentosController::class, 'downloadPdf'])->name('orcamentos.download-pdf');
        Route::post('orcamentos/{id}/send-email', [OrcamentosController::class, 'sendEmail'])->name('orcamentos.send-email');
        Route::get('orcamentos/{id}/send-whatsapp', [OrcamentosController::class, 'redirectWhatsapp'])->name('orcamentos.send-whatsapp');

        Route::get('configuracoes/cabecalho', [OrcamentosController::class, 'headerConfig'])->name('orcamentos.header-config');
        Route::post('configuracoes/cabecalho', [OrcamentosController::class, 'saveHeaderConfig'])->name('orcamentos.header-config.save');
    });

    Route::get('orcamentos/publico/{id}/pdf', [OrcamentosController::class, 'publicPdf'])
        ->middleware('signed')
        ->name('orcamentos.public-pdf');
});
