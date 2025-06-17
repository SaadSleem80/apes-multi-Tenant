<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenants\App\Http\Controllers\TenantsController;

Route::middleware(['auth:sanctum', 'tenant'])->prefix('/v1/tenants')->group(function () {
    Route::get('/' , [TenantsController::class, 'index']);
});