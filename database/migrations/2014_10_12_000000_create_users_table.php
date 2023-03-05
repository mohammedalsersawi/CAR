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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->text('about')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->text('code')->nullable();
            $table->boolean('verification')->default(0);
            $table->foreignId('discount_type_id')->nullable()->constrained('types')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('area_id')->nullable()->constrained('areas')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_type_id')->default(5)->unsigned()->references('id')->on('user_types')->cascadeOnUpdate();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
