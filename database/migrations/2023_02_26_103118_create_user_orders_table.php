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
            $table->tinyInteger('status')->default(3);
            $table->string('phone')->unique();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->nullOnDelete()->cascadeOnUpdate()->nullable();
            $table->foreignId('area_id')->nullable()->references('id')->on('areas')->nullOnDelete()->cascadeOnUpdate()->nullable();
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
