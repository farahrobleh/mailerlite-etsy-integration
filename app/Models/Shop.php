<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['etsy_shop_id', 'access_token', 'mailerlite_group_id'];
}
