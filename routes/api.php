<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::prefix('transactions')->group(function () {
        Route::get('/balance', [TransactionController::class, 'balance']);
        Route::post('/deposit', [TransactionController::class, 'deposit']);
        Route::post('/withdraw', [TransactionController::class, 'withdraw']);
        Route::get('/history', [TransactionController::class, 'history']);
    });

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::get('/users/{user}', [AdminController::class, 'userDetail']);
        Route::get('/users/{user}/transactions', [AdminController::class, 'userTransactions']);
        Route::get('/users/{user}/logs', [AdminController::class, 'userLogs']);
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus']);
        Route::get('/transactions', [AdminController::class, 'transactions']);
        Route::get('/failed-withdrawals', [AdminController::class, 'failedWithdrawals']);
        Route::get('/daily-summary', [AdminController::class, 'dailySummary']);
    });
});
