<?php

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

Route::get('/', [TodosController::class, 'index'])->name('todos');

/*
Grouping todos action/api
*/
Route::prefix('/todos')->group(function () {
    Route::post('/', [TodosController::class, 'store']);
    Route::put('/{id}', [TodosController::class, 'update']);
    Route::delete('/{id}', [TodosController::class, 'destroy']);
});

require __DIR__.'/auth.php';
