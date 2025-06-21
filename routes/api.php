<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('v1')->group(function () {
    Route::post('purchase', [PurchaseController::class, 'purchase']);
    Route::post('/employee/balance', [PurchaseController::class, 'getEmployeeBalance']);
});
