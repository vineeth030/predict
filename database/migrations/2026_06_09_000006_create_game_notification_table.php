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
        Schema::create('game_notification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('notification_type', [
                'REWARD',
                'DAILY_REWARD',
                'PREDICTION_REWARD',
                'CORRECT_PREDICTION',
                'SHARE_SENT',
                'SHARE_RECEIVED',
                'REDEEM',
                'REEDEEM_STAR',
                'COUNTRY_COMPLETE',
            ])->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('message', 1000)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_notification');
    }
};
