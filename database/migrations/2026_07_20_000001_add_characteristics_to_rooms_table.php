<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedInteger('surface_m2')->nullable()->after('wifi_vlan');
            $table->unsignedTinyInteger('capacity')->default(2)->after('surface_m2');
            $table->enum('bed_type', ['simple', 'double', 'queen', 'king', 'twin'])
                  ->default('double')
                  ->after('capacity');
            $table->json('amenities')->nullable()->after('bed_type');
            $table->text('description')->nullable()->after('amenities');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['surface_m2', 'capacity', 'bed_type', 'amenities', 'description']);
        });
    }
};
