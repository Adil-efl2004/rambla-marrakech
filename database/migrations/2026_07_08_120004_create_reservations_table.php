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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reservable_type');
            $table->unsignedBigInteger('reservable_id');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->enum('status', ['en_attente', 'confirmee', 'annulee', 'terminee'])->default('en_attente');
            $table->decimal('total_price', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['reservable_type', 'reservable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
