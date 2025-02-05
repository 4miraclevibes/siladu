<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::post('webhook', [WebhookController::class, 'update'])->middleware('auth:sanctum');
Route::get('transaction', [TransactionController::class, 'index'])->middleware('auth:sanctum');
Route::get('transaction/pengajuan', [TransactionController::class, 'pengajuan'])->middleware('auth:sanctum');

