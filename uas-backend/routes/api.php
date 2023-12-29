<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        // Routes untuk pengguna (hanya lihat/view saja)
        Route::get('mahasiswa', [MahasiswaController::class, 'index']);
        Route::get('mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show']);
        Route::get('mahasiswa/nim/{nim}', [MahasiswaController::class, 'showByNim']);

        // Routes untuk admin (CRUD)
        Route::middleware('can:admin')->group(function () {
            Route::resource('mahasiswa', MahasiswaController::class)->except(['index', 'show']);
        });

        Route::post('logout', 'logout');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
