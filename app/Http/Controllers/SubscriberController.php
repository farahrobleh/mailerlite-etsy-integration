<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        return response()->json(Subscriber::all());
    }
}