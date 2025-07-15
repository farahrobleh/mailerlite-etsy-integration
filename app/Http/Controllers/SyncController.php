<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Services\EtsyMockService;
use App\Models\Shop;
use App\Models\Subscriber;

class SyncController extends Controller
{
    protected $etsyService;

    public function __construct(EtsyMockService $etsyService)
    {
        $this->etsyService = $etsyService;
    }

    public function syncCustomers(Request $request)
    {
        $shop = Shop::first();
        if (!$shop) {
            return response()->json(['error' => 'No shop connected'], 400);
        }

        $transactions = $this->etsyService->getTransactions($shop->etsy_shop_id);
        $client = new Client();

        foreach ($transactions['results'] as $transaction) {
            $email = $transaction['buyer_email'] ?? null;
            if ($email) {
                $subscriber = Subscriber::updateOrCreate(
                    ['email' => $email, 'shop_id' => $shop->id],
                    ['name' => $transaction['buyer_name'] ?? null]
                );

                try {
                    $client->post('https://api.mailerlite.com/api/v2/subscribers', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'X-MailerLite-ApiKey' => env('MAILARLITE_API_KEY')
                        ],
                        'json' => [
                            'email' => $email,
                            'name' => $transaction['buyer_name'] ?? '',
                            'groups' => [$shop->mailerlite_group_id]
                        ]
                    ]);
                    $subscriber->update(['synced' => true]);
                } catch (\Exception $e) {
                    \Log::error('MailerLite sync failed: ' . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Sync completed']);
    }
}