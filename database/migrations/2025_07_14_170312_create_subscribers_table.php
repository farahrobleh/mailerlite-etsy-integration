<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->string('name')->nullable();
            $table->boolean('synced')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}