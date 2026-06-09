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
        Schema::create('game_reward_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('card_id')->constrained('game_card')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->enum('reward_source', [
                'DAILY',
                'PREDICTION',
                'REDEEM',
                'ADMIN',
            ])->nullable();
            $table->timestamp('rewarded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_reward_history');
    }
};
