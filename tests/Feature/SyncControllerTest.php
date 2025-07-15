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
            'mailerlite_group_id' => null
        ]);

        $response = $this->postJson('/api/etsy/sync');
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sync completed']);
        $this->assertDatabaseHas('shops', ['mailerlite_group_id' => 'mock_group_' . $this->anything()]);
        $this->assertDatabaseHas('subscribers', ['email' => 'test1@example.com']);
    }

    public function test_create_campaign_endpoint()
    {
        Shop::create([
            'etsy_shop_id' => 'mock_shop_123',
            'access_token' => 'mock_token_123',
            'mailerlite_group_id' => 'mock_group_123'
        ]);

        $response = $this->postJson('/api/etsy/campaign', ['title' => 'Test Campaign']);
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Campaign created']);
        $this->assertDatabaseHas('campaigns', [
            'title' => 'Test Campaign',
            'mailerlite_campaign_id' => 'mock_campaign_' . $this->anything()
        ]);
    }

    public function test_get_automations_endpoint()
    {
        $response = $this->getJson('/api/automations');
        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['name' => 'Welcome Email']);
    }
}