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
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('model_id')->nullable()->constrained('model_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('engine_id')->nullable()->constrained('engines')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('transmission_id')->nullable()->constrained('transmissions')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('fule_type_id')->nullable()->references('id')->on('fuel_types')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('color_exterior_id')->nullable()->constrained('color_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('color_interior_id')->nullable()->constrained('color_cars')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('mileage');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('year');
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
