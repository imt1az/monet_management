<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']); 
Route::put('/transactions/{id}', [TransactionController::class, 'update']); 
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
Route::get('/report/{year}/{month}', [TransactionController::class, 'getMonthlyReport']); 
Route::get('/total-balance', [TransactionController::class, 'getTotalBalance']); 
// testing
Route::get('/imtiaz', [TransactionController::class, 'hello']);
