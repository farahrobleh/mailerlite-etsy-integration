<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('etsy_shop_id')->unique();
            $table->string('access_token');
            $table->string('mailerlite_group_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}