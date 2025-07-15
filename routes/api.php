<?php

use App\Http\Controllers\SyncController;

Route::post('/etsy/sync', [SyncController::class, 'syncCustomers']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route works']);
});