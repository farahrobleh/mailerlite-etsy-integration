<?php

use App\Http\Controllers\SyncController;

Route::post('/etsy/sync', [SyncController::class, 'syncCustomers']);