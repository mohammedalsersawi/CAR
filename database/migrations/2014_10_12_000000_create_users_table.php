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
            $table->string('number')->unique();
            $table->string('password');
            $table->text('about')->nullable();
            $table->double('lat')->nullable();
            $table->double('leg')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('area_id')->nullable()->constrained('areas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_type_id')->default(5)->constrained('user_types')->cascadeOnDelete()->cascadeOnUpdate();
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
