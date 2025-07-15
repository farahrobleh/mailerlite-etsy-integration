<?php

namespace App\Http\Controllers;

use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        return response()->json(Shop::first());
    }
}