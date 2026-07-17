<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->unsignedTinyInteger('floor');
            $table->enum('type', ['simple', 'double', 'suite']);
            $table->enum('status', ['libre', 'occupee', 'maintenance'])->default('libre');
            $table->decimal('price_per_night', 8, 2);
            $table->string('wifi_vlan')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });

        Schema::dropIfExists('rooms');
    }
};
