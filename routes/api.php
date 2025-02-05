<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\TransactionController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('webhook', [WebhookController::class, 'update'])->middleware('auth:sanctum');
Route::get('transaction', [TransactionController::class, 'index'])->middleware('auth:sanctum');
