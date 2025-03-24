<?php

use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::apiResource('shifts', ShiftController::class);
});