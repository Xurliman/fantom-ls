<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/validate-license', [LicenseController::class, 'validateLicense'])->name('validate.license');
Route::post('/check-if-update-available', [LicenseController::class, 'checkIfUpdateAvailable'])->name('check.update.available');
Route::post('/download-update', [LicenseController::class, 'sendUpdate'])->name('download.update');
Route::post('/verify-update', [LicenseController::class, 'verifyUpdate'])->name('verify.update');

