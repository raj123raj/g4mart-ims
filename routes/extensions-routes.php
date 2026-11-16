<?php
// Copy these routes into routes/web.php (inside the existing web middleware file).
// Keep the existing product CRUD routes; remove duplicate route declarations if present.

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\StockTransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // All signed-in roles can view and record stock movements.
    Route::get('/stock-transactions', [StockTransactionController::class, 'index'])
        ->name('stock-transactions.index');
    Route::get('/stock-transactions/create', [StockTransactionController::class, 'create'])
        ->name('stock-transactions.create');
    Route::post('/stock-transactions', [StockTransactionController::class, 'store'])
        ->name('stock-transactions.store');

    // Only managers can inspect audit history.
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index'])
            ->name('audit-logs.index');
    });
});
