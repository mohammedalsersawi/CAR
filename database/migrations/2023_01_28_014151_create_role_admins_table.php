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
        Schema::create('role_admins', function (Blueprint $table) {
            $table->uuid()->index();
            $table->foreignUuid('admin_uuid')->references('uuid')->on('admins')->cascadeOnDelete();
            $table->foreignUuid('role_uuid')->references('uuid')->on('roles')->cascadeOnDelete();
            $table->primary(['admin_uuid','role_uuid']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_admins');
    }
};
