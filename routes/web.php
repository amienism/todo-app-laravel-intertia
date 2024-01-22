<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/', [TodosController::class, 'index'])->middleware('auth')->name('todos');

Route::prefix('/todos')->group(function () {
    Route::post('/', [TodosController::class, 'store']);
    Route::put('/{id}', [TodosController::class, 'update']);
    Route::delete('/{id}', [TodosController::class, 'destroy']);
});

require __DIR__.'/auth.php';
