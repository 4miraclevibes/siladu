<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\LaboratoryController;
use App\Http\Controllers\Dashboard\ParameterController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\MethodController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\Dashboard\QualityStandartController;
use App\Http\Controllers\Dashboard\TransactionController As DashboardTransactionController;
use App\Http\Controllers\Dashboard\PaymentController As DashboardPaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard
Route::middleware('auth')->group(function () {
    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // Laboratories
    Route::get('laboratories', [LaboratoryController::class, 'index'])->name('laboratories.index');
    Route::post('laboratories', [LaboratoryController::class, 'store'])->name('laboratories.store');
    Route::put('laboratories/{laboratory}', [LaboratoryController::class, 'update'])->name('laboratories.update');
    Route::delete('laboratories/{laboratory}', [LaboratoryController::class, 'destroy'])->name('laboratories.destroy');
    // Packages
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('packages', [PackageController::class, 'store'])->name('packages.store');
    Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
    // Parameters
    Route::get('parameters', [ParameterController::class, 'index'])->name('parameters.index');
    Route::post('parameters', [ParameterController::class, 'store'])->name('parameters.store');
    Route::put('parameters/{parameter}', [ParameterController::class, 'update'])->name('parameters.update');
    Route::delete('parameters/{parameter}', [ParameterController::class, 'destroy'])->name('parameters.destroy');
    // Methods
    Route::get('methods', [MethodController::class, 'index'])->name('methods.index');
    Route::post('methods', [MethodController::class, 'store'])->name('methods.store');
    Route::put('methods/{method}', [MethodController::class, 'update'])->name('methods.update');
    Route::delete('methods/{method}', [MethodController::class, 'destroy'])->name('methods.destroy');
    // Locations
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    // Quality Standarts
    Route::get('quality-standarts', [QualityStandartController::class, 'index'])->name('quality-standarts.index');
    Route::post('quality-standarts', [QualityStandartController::class, 'store'])->name('quality-standarts.store');
    Route::put('quality-standarts/{qualityStandart}', [QualityStandartController::class, 'update'])->name('quality-standarts.update');
    Route::delete('quality-standarts/{qualityStandart}', [QualityStandartController::class, 'destroy'])->name('quality-standarts.destroy');
    // Transactions
    Route::get('dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard.transactions.index');
    Route::get('dashboard/transactions/{transaction}', [DashboardTransactionController::class, 'show'])->name('dashboard.transactions.show');
    Route::patch('dashboard/transactions/{transaction}', [DashboardTransactionController::class, 'updateStatus'])->name('dashboard.transactions.updateStatus');
    // Payments
    Route::get('dashboard/payments', [DashboardPaymentController::class, 'index'])->name('dashboard.payments.index');
});

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth')->name('transaction');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->middleware('auth')->name('transaction.show');
Route::get('/instansi', [TransactionController::class, 'instansi'])->middleware('auth')->name('instansi');
Route::post('/instansi', [TransactionController::class, 'instansiStore'])->middleware('auth')->name('instansi.store');
Route::get('/payment', [PaymentController::class, 'index'])->middleware('auth')->name('payment');
Route::post('/webhook', [WebhookController::class, 'update'])->name('webhook');
require __DIR__.'/auth.php';
