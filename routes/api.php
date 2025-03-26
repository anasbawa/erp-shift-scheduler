<?php

use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ShiftRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::apiResource('shifts', ShiftController::class);

    Route::prefix('shifts')->group(function () {
        Route::post('{shift}/request', [ShiftRequestController::class, 'createRequest']);
        Route::put('approve/{shiftRequest}', [ShiftRequestController::class, 'approveShiftRequest']);
        Route::put('reject/{shiftRequest}', [ShiftRequestController::class, 'rejectShiftRequest']);
    });
});