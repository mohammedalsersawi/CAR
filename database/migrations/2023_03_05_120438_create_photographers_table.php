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
        Schema::create('photographers', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('city_uuid')->nullable()->references('uuid')->on('cities')->nullOnDelete();
            $table->foreignUuid('area_uuid')->nullable()->references('uuid')->on('areas')->nullOnDelete();
            $table->string('phone',15);
            $table->date('date');
            $table->time('time');
            $table->foreignUuid('photographer_uuid')->nullable()->references('uuid')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
             $table->enum('status',['pending','accept','complete'])->default(1);
            $table->foreignUuid('user_uuid')->references('uuid')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('photographers');
    }
};
