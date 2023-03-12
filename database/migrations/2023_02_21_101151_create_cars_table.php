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
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('brand_uuid')->nullable()->references('uuid')->on('brands')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('model_uuid')->nullable()->references('uuid')->on('model_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('engine_uuid')->nullable()->references('uuid')->on('engines')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('transmission_uuid')->nullable()->references('uuid')->on('transmissions')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('fule_type_uuid')->nullable()->references('uuid')->on('fuel_types')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('color_exterior_uuid')->nullable()->references('uuid')->on('color_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('color_interior_uuid')->nullable()->references('uuid')->on('color_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('mileage');
            $table->foreignUuid('user_uuid')->references('uuid')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('year');
            $table->string('phone');
            $table->double('lat');
            $table->double('lng');
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
        Schema::dropIfExists('cars');
    }
};
