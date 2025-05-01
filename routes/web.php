<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenukaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);

//gunakan controller untuk memanggil view penukaran
Route::get('/penukarans1', [PenukaranController::class, 'penukaran1']);
Route::get('/penukarans2', [PenukaranController::class, 'penukaran2']);
Route::get('/penukarans3', [PenukaranController::class, 'penukaran3']);
Route::get('/penukarans3_2', [PenukaranController::class, 'penukaran3_2']);


//return view penukarans2
Route::get('/penukarans2', function () {
    return view('penukarans2');
});

