<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PaymentController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/home', [HomeController::class, 'index'])->middleware('auth:sanctum');

//Transaction
Route::get('transaction', [TransactionController::class, 'index'])->middleware('auth:sanctum');
Route::get('transaction/pengajuan', [TransactionController::class, 'pengajuan'])->middleware('auth:sanctum');
Route::post('transaction/pengajuan', [TransactionController::class, 'pengajuanStore'])->middleware('auth:sanctum');
Route::get('transaction/pengajuan/{id}', [TransactionController::class, 'pengajuanShow'])->middleware('auth:sanctum');

//Payment
Route::get('payment', [PaymentController::class, 'index'])->middleware('auth:sanctum');
Route::get('payment/{id}', [PaymentController::class, 'show'])->middleware('auth:sanctum');
Route::post('payment/{id}', [PaymentController::class, 'update'])->middleware('auth:sanctum');


//Pending Feature
Route::post('webhook', [WebhookController::class, 'update'])->middleware('auth:sanctum');