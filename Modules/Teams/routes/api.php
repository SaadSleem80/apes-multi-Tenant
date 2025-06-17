<?php

use Illuminate\Support\Facades\Route;
use Modules\Teams\App\Http\Controllers\TeamAvailabilityController;
use Modules\Teams\App\Http\Controllers\TeamsController;

Route::middleware(['auth:sanctum', 'tenant'])->prefix('/v1/teams')->group(function () {
    Route::get('/' , [TeamsController::class, 'index']);
    Route::post('/' , [TeamsController::class, 'store']);

    Route::get('/{id}/generate-slots' , [TeamAvailabilityController::class, 'generateSlots']);
    Route::post('/{id}/availability' , [TeamAvailabilityController::class, 'store']);
});
