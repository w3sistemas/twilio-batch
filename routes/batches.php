<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', [BatchController::class, 'index'])->name('batches');
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batches/{batch}/download', [BatchController::class, 'download'])->name('batches.download');
});
