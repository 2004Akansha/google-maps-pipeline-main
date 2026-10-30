<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtractionJobController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return redirect()->route('sources.index');
});

Route::resource('sources', SourceController::class);

Route::get('/businesses', [BusinessController::class, 'index'])
    ->name('businesses.index');

Route::get('/businesses/{business}', [BusinessController::class, 'show'])
    ->name('businesses.show');

Route::get(
    '/businesses/{business}/reviews',
    [ReviewController::class, 'index']
)->name('businesses.reviews');

Route::get(
    '/businesses/{business}/photos',
    [PhotoController::class, 'index']
)->name('businesses.photos');

Route::get('/extraction-jobs',
    [ExtractionJobController::class, 'index']
)->name('extraction-jobs.index');

Route::get('/sources/{source}/extraction-jobs/create',
    [ExtractionJobController::class, 'create']
)->name('extraction-jobs.create');

Route::post('/sources/{source}/extraction-jobs',
    [ExtractionJobController::class, 'store']
)->name('extraction-jobs.store');

Route::get('/extraction-jobs/{extractionJob}',
    [ExtractionJobController::class, 'show']
)->name('extraction-jobs.show');


