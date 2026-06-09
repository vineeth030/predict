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
        Schema::create('game_user_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('card_id')->constrained('game_card')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamp('first_obtained_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->unique(['user_id', 'card_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_user_card');
    }
};
