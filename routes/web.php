<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\EraApiController;

Route::get('/timeline', [EventController::class, 'index']);

// API Routes
Route::prefix('api')->group(function () {
    // Event API Routes
    Route::get('/events', [EventApiController::class, 'index']);
    Route::post('/events', [EventApiController::class, 'store']);
    Route::get('/events/{event}', [EventApiController::class, 'show']);
    Route::put('/events/{event}', [EventApiController::class, 'update']);
    Route::delete('/events/{event}', [EventApiController::class, 'destroy']);
    
    // Era API Routes
    Route::get('/eras', [EraApiController::class, 'index']);
    Route::post('/eras', [EraApiController::class, 'store']);
    Route::get('/eras/{era}', [EraApiController::class, 'show']);
    Route::put('/eras/{era}', [EraApiController::class, 'update']);
    Route::delete('/eras/{era}', [EraApiController::class, 'destroy']);
});