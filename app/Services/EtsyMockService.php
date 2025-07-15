<?php

namespace App\Services;

class EtsyMockService
{
    public function getTransactions($shopId)
    {
        // Mock Etsy /shops/{shop_id}/transactions response
        return [
            'results' => [
                ['buyer_email' => 'test1@example.com', 'buyer_name' => 'Test User 1'],
                ['buyer_email' => 'test2@example.com', 'buyer_name' => 'Test User 2']
            ]
        ];
    }

    public function getAuthUrl($keystring)
    {
        // Mock OAuth URL (for demo purposes)
        return "https://www.etsy.com/oauth/connect?client_id=$keystring&redirect_uri=http://localhost:8000/api/etsy/callback&scope=transactions_r&state=superstate";
    }

    public function getAccessToken($code)
    {
        // Mock access token response
        return ['access_token' => 'mock_token_' . $code, 'shop_id' => 'mock_shop_123'];
    }
}