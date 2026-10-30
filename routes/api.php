<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BusinessImportController;
use App\Http\Controllers\Api\ExtractionJobApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/import/business',
    [BusinessImportController::class, 'store']
);

Route::get(
    '/extraction-jobs/{extractionJob}',
    [ExtractionJobApiController::class, 'show']
)->name('api.extraction-jobs.show');
