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
            $table->uuid()->primary();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->text('about')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->text('code')->nullable();
            $table->boolean('verification')->default(0);
            $table->char('discount_type_uuid', 36)->nullable();
            $table->foreign('discount_type_uuid')->references('uuid')->on('types')->nullOnDelete()->cascadeOnUpdate();
            $table->char('city_uuid', 36)->nullable();
            $table->foreign('city_uuid')->references('uuid')->on('cities')->nullOnDelete();
            $table->char('area_uuid', 36)->nullable();
            $table->foreign('area_uuid')->references('uuid')->on('areas')->nullOnDelete();
            $table->char('user_type_uuid', 36);
            $table->foreign('user_type_uuid')->default(5)->references('uuid')->on('user_types');
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
