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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', [
                'climatisation',
                'eau_chaude',
                'television',
                'wifi',
                'plomberie',
                'electricite',
                'autre',
            ])->default('autre');
            $table->text('description')->nullable();
            $table->enum('priority', ['basse', 'moyenne', 'urgente'])->default('moyenne');
            $table->enum('status', ['ouverte', 'en_cours', 'resolue'])->default('ouverte');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
