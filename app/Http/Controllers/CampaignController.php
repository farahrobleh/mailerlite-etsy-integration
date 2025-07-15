<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        return response()->json(Campaign::all()->map(function ($campaign) {
            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'analytics' => $campaign->analytics ?? ['open_rate' => 'N/A', 'click_rate' => 'N/A', 'subscribers_reached' => 'N/A']
            ];
        }));
    }
}