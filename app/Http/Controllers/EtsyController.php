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
        $url = $this->etsyService->getAuthUrl(env('ETSY_KEYSTRING'));
        return redirect($url);
    }

    public function handleEtsyCallback(Request $request)
    {
        $code = $request->query('code', 'mock_code');
        $tokenData = $this->etsyService->getAccessToken($code);
        Shop::updateOrCreate(
            ['etsy_shop_id' => $tokenData['shop_id']],
            ['access_token' => $tokenData['access_token'], 'mailerlite_group_id' => 'mock_group_123']
        );
        return redirect('/dashboard');
    }
}

