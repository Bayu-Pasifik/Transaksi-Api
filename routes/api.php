<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/proses', [ProsesController::class, 'index']);
    Route::post('/proses', [ProsesController::class, 'store']);
    Route::get('/proses/{id}', [ProsesController::class, 'show']);
    Route::delete('/proses/{id}', [ProsesController::class, 'destroy']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions/{id_proses}', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
});


Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);