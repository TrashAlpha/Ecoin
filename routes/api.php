<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenukaranKoinController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\ArtikelController;

Route::middleware(['web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/vouchers', [PenukaranKoinController::class, 'getAvailableVouchers'])->name('vouchers.list');
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/get-user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::put('/update-profile', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
    Route::post('/exchange-voucher', [PenukaranKoinController::class, 'exchangeVoucher'])->name('vouchers.exchange');
    Route::post('/confirm-exchange', [PenukaranKoinController::class, 'confirmExchange'])->name('vouchers.confirm');
});

// Admin API Routes - Protected with admin middleware
Route::middleware(['web', 'admin'])->group(function () {
    // Data fetching
    Route::get('/admin/vouchers', [AdminPageController::class, 'getAllVouchers']);
    Route::get('/admin/users', [AdminPageController::class, 'getAllUsers']);
    Route::get('/admin/pending-verifications', [AdminPageController::class, 'getPendingVerifications']);
    
    // Verification management
    Route::post('/admin/exchanges/{id}/approve', [AdminPageController::class, 'approveExchange']);
    Route::post('/admin/exchanges/{id}/reject', [AdminPageController::class, 'rejectExchange']);
    
    // Voucher management
    Route::post('/admin/vouchers', [AdminPageController::class, 'createVoucher']);
    Route::put('/admin/vouchers/{id}', [AdminPageController::class, 'updateVoucher']);
    Route::delete('/admin/vouchers/{id}', [AdminPageController::class, 'deleteVoucher']);
    
    // User management
    Route::put('/admin/users/{id}/status', [AdminPageController::class, 'updateUserStatus']);
    Route::put('/admin/users/{id}/coins', [AdminPageController::class, 'updateUserCoins']);
    
    // Sampah management
    Route::apiResource('admin/sampah', SampahController::class);
    
    // Article management
    Route::apiResource('admin/artikel', ArtikelController::class);
    Route::post('/admin/artikel/{id}/submit-quiz', [ArtikelController::class, 'submitQuiz']);
});

// Public API routes
Route::get('/sampah', [SampahController::class, 'index']);
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/{id}', [ArtikelController::class, 'show']);
