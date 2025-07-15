<?php

use App\Http\Controllers\SyncController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\EtsyController;

Route::post('/etsy/sync', [SyncController::class, 'syncCustomers']);

Route::post('/etsy/campaign', [SyncController::class, 'createCampaign']);

Route::get('/subscribers', [SubscriberController::class, 'index']);

Route::get('/campaigns', [CampaignController::class, 'index']);

Route::get('/shop', [ShopController::class, 'index']);

Route::get('/etsy/products', [EtsyController::class, 'getProducts']);

Route::get('/automations', [SyncController::class, 'getAutomations']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route works']);
});