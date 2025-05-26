<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenukaranKoinController;
use App\Http\Controllers\AdminPageController;

Route::middleware(['web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/vouchers', [PenukaranKoinController::class, 'getAvailableVouchers'])->name('vouchers.list');
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware(['web', 'auth'])->group(function () { // Gunakan middleware 'web'
    Route::get('/get-user', [AuthController::class, 'getUser'])->name('auth.getUser');
});

// Fetch data
Route::get('/vouchers', [AdminPageController::class, 'getAllVouchers']);
Route::get('/users', [AdminPageController::class, 'getAllUsers']);
