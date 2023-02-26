<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->uuid();
            $table->text('name');
            $table->string('phone')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->foreignId('city_id')->references('id')->on('cities')->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->foreignId('area_id')->references('id')->on('areas')->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
};
