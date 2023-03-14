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
            $table->uuid()->primary();
            $table->text('name');
            $table->tinyInteger('status')->default(3);
            $table->string('phone');
            $table->foreignUuid('user_uuid')->references('uuid')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('city_uuid')->nullable()->references('uuid')->on('cities')->nullOnDelete();
            $table->foreignUuid('area_uuid')->nullable()->references('uuid')->on('areas')->nullOnDelete();
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
