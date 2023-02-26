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
            $table->id();
            $table->uuid();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnUpdate();
            $table->foreignId('model_id')->constrained('model_cars')->cascadeOnUpdate();
            $table->foreignId('engine_id')->constrained('engines')->cascadeOnUpdate();
            $table->foreignId('transmission_id')->constrained('transmissions')->cascadeOnUpdate();
            $table->foreignId('fule_type_id')->constrained('fuel_types')->cascadeOnDelete();
            $table->foreignId('color_exterior_id')->constrained('color_cars')->cascadeOnUpdate();
            $table->foreignId('color_interior_id')->constrained('color_cars')->cascadeOnUpdate();
            $table->integer('mileage');
            $table->integer('year_from');
            $table->integer('year_to');
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
