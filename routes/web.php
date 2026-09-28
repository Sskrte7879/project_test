<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NdaContractController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ContractController::class, 'index'])->name('dashboard');

    // Contracts Routes
    Route::get('/contracts/create/{type?}', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.generate');
    Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');
    
    // PDF Routes (Preview & Download)
    Route::get('/contracts/{contract}/preview', [ContractController::class, 'previewPdf'])->name('contracts.preview');
    Route::get('/contracts/{contract}/pdf', [ContractController::class, 'downloadPdf'])->name('contracts.pdf');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   // NDA Contract Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/nda/create', [App\Http\Controllers\NdaContractController::class, 'create'])->name('nda.create');
        Route::post('/nda/store', [App\Http\Controllers\NdaContractController::class, 'store'])->name('nda.store');
        Route::get('/nda/{ndaContract}/preview', [App\Http\Controllers\NdaContractController::class, 'preview'])->name('nda.preview');
        Route::get('/nda/{ndaContract}/pdf', [App\Http\Controllers\NdaContractController::class, 'downloadPdf'])->name('nda.pdf');
        Route::delete('/nda/{ndaContract}', [App\Http\Controllers\NdaContractController::class, 'destroy'])->name('nda.destroy');
    });
});

require __DIR__.'/auth.php';