<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/stock-transactions',
        [StockTransactionController::class, 'index'])
        ->name('stock-transactions.index');

    Route::get('/stock-transactions/create',
        [StockTransactionController::class, 'create'])
        ->name('stock-transactions.create');

    Route::post('/stock-transactions',
        [StockTransactionController::class, 'store'])
        ->name('stock-transactions.store');

     Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Audit Logs - Manager only
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/audit-logs',
        [AuditLogController::class, 'index'])
        ->name('audit-logs.index');
});

require __DIR__.'/auth.php';
