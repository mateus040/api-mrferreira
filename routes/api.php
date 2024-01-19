<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanysController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rotas protegidas
    Route::get('companys', [CompanysController::class, 'index']);
    Route::get('companys/{id}', [CompanysController::class, 'show']);
    Route::post('companys/add', [CompanysController::class, 'store']);
    Route::put('companys/update/{id}', [CompanysController::class, 'update']);
    Route::delete('companys/delete/{id}', [CompanysController::class, 'destroy']);

    Route::get('products', [ProductsController::class, 'index']);
    Route::get('products/{id}', [ProductsController::class, 'show']);
    Route::post('products/add', [ProductsController::class, 'store']);
    Route::put('products/update/{id}', [ProductsController::class, 'update']);
    Route::delete('products/delete/{id}', [ProductsController::class, 'destroy']);
});