<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenukaranKoinController;

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])
     ->middleware('web');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
// Route::get('/get-user', [AuthController::class, 'getUser'])->name('auth.getUser');

Route::middleware(['web', 'auth'])->group(function () { // Gunakan middleware 'web'
    Route::get('/get-user', [AuthController::class, 'getUser'])->name('auth.getUser');
});

// Penukaran Koin API Routes
Route::get('/user/{id}/saldo', [PenukaranKoinController::class, 'getSaldo'])->name('user.saldo');
Route::get('/vouchers', [PenukaranKoinController::class, 'getAvailableVouchers'])->name('vouchers.list');