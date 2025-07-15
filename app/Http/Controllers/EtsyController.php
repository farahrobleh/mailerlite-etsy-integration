<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EtsyMockService;
use App\Models\Shop;

class EtsyController extends Controller
{
    protected $etsyService;

    public function __construct(EtsyMockService $etsyService)
    {
        $this->etsyService = $etsyService;
    }

    public function redirectToEtsy()
    {
        $keystring = env('ETSY_KEYSTRING');
        return redirect($this->etsyService->getAuthUrl($keystring));
    }

    public function handleEtsyCallback(Request $request)
    {
        $code = $request->query('code');
        $tokenData = $this->etsyService->getAccessToken($code);
        Shop::updateOrCreate(
            ['etsy_shop_id' => $tokenData['shop_id']],
            ['access_token' => $tokenData['access_token'], 'mailerlite_group_id' => 'mock_group_123']
        );
        return redirect('/');
    }

    public function getProducts()
    {
        $shop = Shop::first();
        if (!$shop) {
            return response()->json(['error' => 'No shop connected'], 400);
        }
        return response()->json($this->etsyService->getProducts($shop->etsy_shop_id));
    }
}

