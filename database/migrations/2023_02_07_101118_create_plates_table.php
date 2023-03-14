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
        Schema::create('plates', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->smallInteger('numberone');
            $table->smallInteger('numbertow');
            $table->string('stringone',3);
            $table->string('stringtow',3);
            $table->string('phone');
            $table->enum('status',[0,1])->default(0);
            $table->foreignUuid('city_uuid')->nullable()->references('uuid')->on('cities')->nullOnDelete();
            $table->foreignUuid('user_uuid')->nullable()->references('uuid')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('price');
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
        Schema::dropIfExists('plates');
    }
};
