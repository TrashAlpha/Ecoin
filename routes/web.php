<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PenukaranController;
use App\Http\Controllers\JelajahController;
use App\Http\Controllers\AdminPageController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/beranda', [PageController::class, 'home'])->name('home');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang'); //tes halaman verifikasi penukaran
Route::get('/jelajah', [PageController::class, 'jelajah'])->name('jelajah');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/penukaran1', [PageController::class, 'penukaran1'])->name('penukaran1');
Route::get('/penukaran2', [PageController::class, 'penukaran2'])->name('penukaran2');
Route::get('/penukaran3', [PageController::class, 'penukaran3'])->name('penukaran3');
Route::get('/penukaran3_2', [PageController::class, 'penukaran3_2'])->name('penukaran3_2');
Route::get('/penukaran_koin', [PageController::class, 'penukaran_koin'])->name('penukaran_koin');

//Halaman Admin
Route::get('/admin/verifikasi-penukaran', [AdminPageController::class, 'verifikasiPenukaran'])->name('verifikasi-penukaran');
Route::get('/admin/kelola-voucher', [AdminPageController::class, 'kelolaVoucher'])->name('kelola-voucher');
Route::get('/admin/kelola-user', [AdminPageController::class, 'kelolaUser'])->name('kelola-user');

// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::resource('tests', TestController::class); // test route resource
