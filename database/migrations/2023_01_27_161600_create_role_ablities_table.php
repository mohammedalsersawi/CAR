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
        Schema::create('role_ablities', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('ablity');
            $table->foreignUuId('role_uuid')->references('uuid')->on('roles')->cascadeOnDelete();
            $table->enum('type',[0,1]);
            $table->unique(['ablity','role_uuid']);
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
        Schema::dropIfExists('role_ablities');
    }
};
