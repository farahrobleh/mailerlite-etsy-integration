<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Shop;

class SyncControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_customers_endpoint()
    {
        Shop::create([
            'etsy_shop_id' => 'mock_shop_123',
            'access_token' => 'mock_token_123',
            'mailerlite_group_id' => 'mock_group_123'
        ]);

        $response = $this->postJson('/api/etsy/sync');
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sync completed']);
    }
}