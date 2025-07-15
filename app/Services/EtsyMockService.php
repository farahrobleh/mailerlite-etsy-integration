<?php

namespace App\Services;

class EtsyMockService
{
    public function getTransactions($shopId)
    {
        return [
            'results' => [
                ['buyer_email' => 'test1@example.com', 'buyer_name' => 'Test User 1'],
                ['buyer_email' => 'test2@example.com', 'buyer_name' => 'Test User 2'],
            ]
        ];
    }

    public function getAuthUrl($keystring)
    {
        return "https://www.etsy.com/oauth/connect?client_id=$keystring&redirect_uri=http://localhost:8000/api/etsy/callback&scope=transactions_r&state=superstate";
    }

    public function getAccessToken($code)
    {
        return ['access_token' => 'mock_token_' . $code, 'shop_id' => 'mock_shop_123'];
    }

    public function getProducts($shopId)
    {
        return [
            'results' => [
                [
                    'listing_id' => 1,
                    'title' => 'Handmade Necklace',
                    'price' => '29.99',
                    'image_url' => 'https://images.pexels.com/photos/135486/pexels-photo-135486.jpeg?auto=compress&w=150&h=150&fit=crop' // handmade necklace
                ],
                [
                    'listing_id' => 2,
                    'title' => 'Vintage Mug',
                    'price' => '15.00',
                    'image_url' => 'https://images.pexels.com/photos/1724184/pexels-photo-1724184.jpeg?auto=compress&w=150&h=150&fit=crop' // vintage mug
                ],
            ]
        ];
    }
}