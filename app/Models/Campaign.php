<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['shop_id', 'title', 'content', 'mailerlite_campaign_id', 'analytics'];
    protected $casts = ['analytics' => 'array'];
}