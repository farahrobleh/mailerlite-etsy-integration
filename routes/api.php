<?php

use App\Http\Controllers\SyncController;
use App\Http\Controllers\SubscriberController;

Route::post('/etsy/sync', [SyncController::class, 'syncCustomers']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route works']);
});

Route::get('/subscribers', [SubscriberController::class, 'index']);