<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\VatModelController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Publiczne: rejestracja, logowanie i odświeżanie
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn(Request $r) => $r->user());
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('vat', VatModelController::class);
    Route::apiResource('products', ProductController::class)
        ->middleware(['role:admin']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

