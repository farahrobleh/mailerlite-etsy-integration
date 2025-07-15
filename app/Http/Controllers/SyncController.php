<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Services\EtsyMockService;
use App\Services\MailerLiteMockService;
use App\Models\Shop;
use App\Models\Subscriber;
use App\Models\Campaign;

class SyncController extends Controller
{
    protected $etsyService;
    protected $mailerLiteService;

    public function __construct(EtsyMockService $etsyService, MailerLiteMockService $mailerLiteService)
    {
        $this->etsyService = $etsyService;
        $this->mailerLiteService = $mailerLiteService;
    }

    public function syncCustomers(Request $request)
    {
        $shop = Shop::first();
        if (!$shop) {
            return response()->json(['error' => 'No shop connected'], 400);
        }

        if (!$shop->mailerlite_group_id) {
            $group = $this->mailerLiteService->createGroup('Etsy Customers');
            $shop->update(['mailerlite_group_id' => $group['id']]);
        }

        $transactions = $this->etsyService->getTransactions($shop->etsy_shop_id);
        foreach ($transactions['results'] as $transaction) {
            $email = $transaction['buyer_email'] ?? null;
            if ($email) {
                $subscriber = Subscriber::updateOrCreate(
                    ['email' => $email, 'shop_id' => $shop->id],
                    ['name' => $transaction['buyer_name'] ?? null]
                );

                try {
                    $this->mailerLiteService->addSubscriberToGroup(
                        $shop->mailerlite_group_id,
                        $email,
                        $transaction['buyer_name'] ?? ''
                    );
                    $subscriber->update(['synced' => true]);

                    // Trigger mock welcome automation
                    $this->mailerLiteService->createAutomation(
                        'Welcome Email for ' . $email,
                        'subscriber_added',
                        'send_welcome_email'
                    );
                } catch (\Exception $e) {
                    \Log::error('MailerLite sync failed: ' . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Sync completed']);
    }

    public function createCampaign(Request $request)
    {
        $shop = Shop::first();
        if (!$shop) {
            return response()->json(['error' => 'No shop connected'], 400);
        }

        $products = $request->input('products', $this->etsyService->getProducts($shop->etsy_shop_id)['results']);
        $campaignData = $this->mailerLiteService->createCampaign(
            $request->input('title', 'Etsy Campaign'),
            json_encode($products)
        );

        $campaign = Campaign::create([
            'shop_id' => $shop->id,
            'title' => $campaignData['title'],
            'content' => $campaignData['content'],
            'mailerlite_campaign_id' => $campaignData['id'],
            'analytics' => $campaignData['analytics']
        ]);

        return response()->json([
            'message' => 'Campaign created',
            'campaign' => $campaign
        ]);
    }

    public function getAutomations()
    {
        return response()->json($this->mailerLiteService->getAutomations());
    }
}