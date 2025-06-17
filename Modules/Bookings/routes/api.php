<?php

use Illuminate\Support\Facades\Route;
use Modules\Bookings\App\Http\Controllers\BookingsController;

Route::middleware(['auth:sanctum', 'tenant'])->prefix('/v1/bookings')->group(function () {
    Route::get('/' , [BookingsController::class, 'index']);
    Route::post('/' , [BookingsController::class, 'store']);
    Route::delete('/{id}' , [BookingsController::class, 'delete']);
});

