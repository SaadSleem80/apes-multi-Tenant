<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenants\App\Http\Controllers\TenantsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tenants', TenantsController::class)->names('tenants');
});
